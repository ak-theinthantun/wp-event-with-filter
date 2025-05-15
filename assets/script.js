;(($) => {
    if(typeof wpEventsFilter === 'undefined') {
        window.wpEventsFilter = {};
    }
    class EventsFilter{
        constructor(element) {
            this.element = $(element);
            this.form = this.element.find('.wp-events-filter__form')
            this.results = this.element.find('.wp-events-filter__events')
            this.pagination = this.element.find('.wp-events-filter__pagination')
            this.loading = this.element.find('.wp-events-filter__loading')
            this.countDisplay = this.element.find('.wp-events-filter__count')

            this.searchInput = this.form.find('input[name="search"]');
            this.eventTypeCheckboxes = this.form.find('input[name="event_type[]"]');
            this.eventCategoryCheckboxes = this.form.find('input[name="event_category[]"]');
            this.sortSelect = this.form.find('select[name="sort"]');
            this.perPageSelect = this.form.find('select[name="per_page"]');
            this.resetButton = this.form.find('.wp-events-filter__reset-button');

            this.currentPage = 1;
            this.perPage = this.element.data('per-page') || 6;

            this.perPageSelect.val(this.perPage);
            
            this.init();
        }
        init(){
            this.loadEvents();
            this.searchInput.on('input', $.debounce(500, () => {
                this.currentPage = 1;
                this.loadEvents();
            }),
            )
            this.eventTypeCheckboxes.on('change', () => {
                this.currentPage = 1;
                this.loadEvents();
            });
            this.eventCategoryCheckboxes.on('change', () => {
                this.currentPage = 1;
                this.loadEvents();
            });

            this.sortSelect.on('change', () => {
                this.currentPage = 1;
                this.loadEvents();
            });

            this.perPageSelect.on('change', () => {
                this.currentPage = 1;
                this.perPage = this.perPageSelect.val();
                this.loadEvents();
            });

            this.resetButton.on('click', (e) => {
                this.resetFilters();
            });

            this.pagination.on('click', '.page-numbers', (e) => {
                e.preventDefault();
                const page = $(e.currentTarget).data('page');
                if (page) {
                    this.currentPage = page;
                    this.loadEvents();
                    // $('html, body').animate({
                    //     scrollTop: this.element.offset().top - 100
                    // }, 500);     
                }
            });
        }
        resetFilters(){
            this.searchInput.val('')
            this.eventTypeCheckboxes.prop('checked',false);
            this.eventCategoryCheckboxes.prop('checked',false);
            this.sortSelect.val('newest');
            this.perPageSelect.val(this.element.data('per-page') || 6);
            this.currentPage = 1;
            this.loadEvents();
        }
        loadEvents(){
            this.loading.show();
            this.results.hide();

            const search = this.searchInput.val();
            const sort = this.sortSelect.val();

            const eventTypes = []
            this.eventTypeCheckboxes.filter(':checked').each(function() {
                eventTypes.push($(this).val());
            });

            const eventCategories = [];
            this.eventCategoryCheckboxes.filter(':checked').each(function() {
                eventCategories.push($(this).val());
            });

            const params = {
                search: search,
                event_type: eventTypes,
                event_category: eventCategories,
                sort: sort,
                per_page: this.perPage,
                page: this.currentPage,
            };

            $.ajax({
                url: wpEventsFilter.apiUrl,
                method: 'GET',
                data: params,
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', wpEventsFilter.nonce);
                },
                success: (response) => {
                    this.renderEvents(response);
                    this.renderPagination(response);
                    this.renderCount(response);

                    this.loading.hide();
                    this.results.show();
                },
                error: (error) => {
                    console.error('Error loading events:', error);
                    this.loading.hide();
                    this.results.html('<p class="error">Error loading events. Please try again later.</p>');
                    this.results.show();
                    this.pagination.empty();
                }
            })

        }
        renderEvents(response){
            this.results.empty();
             if (!Array.isArray(response.events) || response.events.length === 0) {
                this.results.html('<p class="no-results">No events found.</p>');
                return;
            }

           response.events.forEach((event) => {
                const eventItem = `
                <div class="wp-events-filter__event-item">
                    <a href="${event.permalink}">
                        <div class="wp-events-filter__event-image">
                            ${event.thumbnail.url ? `<img src="${event.thumbnail.url}" alt="${event.thumbnail.alt || event.title}">` : ''}
                            ${event.types.some(type => type.slug === 'upcoming-events') ? `<span class="event-status">${event.types.find(type => type.slug === 'upcoming-events')?.name}</span>` : ''}

                        </div>
                        <div class="event-conten-parts">
                            <div class="wp-events-filter__event-meta date flex align-items-center">
                                <img src="${route.pluginUrl}imgs/time-icon.svg" /><span>${event.date}</span>
                            </div>
                            <h3 class="fs-20">${event.title}</h3>
                        </div>
                        <div class="wp-events-filter__event-excerpt">
                            ${event.excerpt}
                        </div>
                        <a class="wp-events-filter__permalink" href="${event.permalink}">Read More</a>
                    </a>
                </div>
                `;
                this.results.append(eventItem);
            });
        };
        renderCount(response){
            const total = response.total;
            let start = 0
            let end = 0;
            if(total > 0) {
                start = (this.currentPage - 1) * this.perPage + 1;
                end = Math.min(this.currentPage * this.perPage, total);
            }
            if(total > 0) {
                this.countDisplay.text(`Showing ${start} - ${end} events,Total ${total} events`);
            }
        };
        renderPagination(response){
            this.pagination.empty();
            if(response.total_pages <= 1) {
                return;
            }
            let startPage = Math.max(1, this.currentPage - 2);
            const endPage = Math.min(response.total_pages, startPage + 4);
            if(endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }
            if(this.currentPage > 1) {
                this.pagination.append(`
                    <a href="#" class="page-numbers" data-page="${this.currentPage - 1}"><img src="${route.pluginUrl}imgs/left-arrow-icon.svg" /></a>
                `);
            }
            for(let i = startPage; i <= endPage; i++) {
                if(i === this.currentPage) {
                    this.pagination.append(`
                        <span class="page-numbers current">${i}</span>
                    `);
                } else {
                    this.pagination.append(`
                        <a href="#" class="page-numbers" data-page="${i}">${i}</a>
                    `);
                }
            }
            if(this.currentPage < response.total_pages) {
                this.pagination.append(`
                    <a href="#" class="page-numbers" data-page="${this.currentPage + 1}"><img src="${route.pluginUrl}imgs/right-arrow-icon.svg" /></a>
                `);
            }
        }
    }
    $.debounce = (delay, callback) => {
        let timeout
        return function() {
            const args = arguments
            clearTimeout(timeout)
            timeout = setTimeout(() => {
                callback.apply(this, args)
            }, delay)
        };
    }


    $(document).ready(() => {
        $('.wp-events-filter').each(function() {  // Regular function preserves 'this'
            new EventsFilter(this);
        });
    });


})(jQuery);
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

            this.customSelects = this.form.find('.wp-events-filter__custom--select');
            this.resetButton = this.form.find('.wp-events-filter__reset-button');

            this.currentPage = 1;
            this.perPage = this.element.data('per-page') || 6;
            this.sort = 'newest';
           
            this.init();
        }
        init(){
            this.initCustomSelects()
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
            $(document).on('click', (e) => {
                if (!$(e.target).closest('.wp-events-filter__custom--select').length) {
                    this.customSelects.removeClass('open');
                }
            })
           $('.view-post button').on('click', function (e) {
                e.preventDefault();

                const viewType = $(this).data('view');
                $('.view-post button').removeClass('active');
                $(this).addClass('active');
                $('.wp-events-filter__events').attr('data-view', viewType);
            });
            $('#filter-mobile-trigger').on('click', function(e){
                e.preventDefault();
                $('.wp-events-filter__filters_wrapper').addClass('active');
            });
            $('#close-filter').on('click', function(e){
                e.preventDefault();
                $('.wp-events-filter__filters_wrapper').removeClass('active');
            });
            $('.filter-header').on('click', function(e) {
                e.preventDefault();
                let selected = $(this).closest('.wp-events-filter__filter');
                selected.toggleClass('active');
                selected.find('.wp-events-filter__checkbox-group').toggleClass('hidden');
            });


            
        }
        initCustomSelects(){
            this.customSelects.each((index, select) => {
                const $select = $(select);
                const name = $select.data('name');
                const $selectedOption = $select.find('.wp-events-filter__selected-option');
                const $options = $select.find('.wp-events-filter__options');
                const $optionItems = $select.find('.wp-events-filter__option');

                if(name ==="per_page"){
                    const initialValue = this.perPage.toString();
                    $optionItems.filter(`[data-value="${initialValue}"]`).addClass('selected');
                }else if( name === "sort"){
                    $optionItems.filter(`[data-value="${this.sort}"]`).addClass('selected');
                }

                $selectedOption.on('click', (e) => {
                    $select.toggleClass('open');
                    this.customSelects.not($select).removeClass('open');
                });

                $optionItems.on('click', (e) => {
                    const $option = $(e.currentTarget);
                    const value = $option.data('value');
                    const text = $option.text();

                    $selectedOption.text(text);
                    $optionItems.removeClass('selected');
                    $option.addClass('selected');
                    $select.removeClass('open');

                    if(name === "sort"){
                        this.sort = value;
                    }else if(name === "per_page"){
                        this.perPage = Number.parseInt(value, 10);
                    }

                    this.currentPage = 1;
                    this.loadEvents();
                });
            });
        }

        resetFilters(){
            this.searchInput.val('')
            this.eventTypeCheckboxes.prop('checked',false);
            this.eventCategoryCheckboxes.prop('checked',false);

            this.customSelects.each((index, select) => {
                const $select = $(select);
                const name = $select.data('name');
                const $selectedOption = $select.find('.wp-events-filter__selected-option');
                const $options = $select.find('.wp-events-filter__options');
                const $optionItems = $select.find('.wp-events-filter__option');
                if(name ==="sort"){
                    const $defaultOption = $optionItems.filter(`[data-value="newest"]`);
                    $selectedOption.text($defaultOption.text());
                    $optionItems.removeClass('selected');
                    $defaultOption.addClass('selected');
                    this.sort = 'newest';
                }else if (name === "per_page"){
                    const defaultPerPage = this.element.data('per-page') || 6;
                    const $defaultOption = $optionItems.filter(`[data-value="${defaultPerPage}"]`);
                    $selectedOption.text($defaultOption.text());
                    $optionItems.removeClass('selected');
                    $defaultOption.addClass('selected');
                    this.perPage = defaultPerPage;
                }
            });

            this.currentPage = 1;
            this.loadEvents();
        }
        loadEvents(){
            this.loading.show();
            this.results.hide();

            const search = this.searchInput.val();

            // const sort = this.sortSelect.val();

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
                sort: this.sort,
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
                    <div class="layout-wrapper">

                        <a href="${event.permalink}" class="wp-events-filter__event-image">
                            ${event.thumbnail.url ? `<img src="${event.thumbnail.url}" alt="${event.thumbnail.alt || event.title}">` : ''}
                            ${event.types.some(type => type.slug === 'upcoming-events') ? `<span class="event-status">${event.types.find(type => type.slug === 'upcoming-events')?.name}</span>` : ''}
                        </a>

                        <div class="list-layout-wrapper">
                            <div class="event-conten-parts">
                                <div class="wp-events-filter__event-meta date flex align-items-center">
                                    <img src="${route.pluginUrl}imgs/time-icon.svg" /><span>${event.date}</span>
                                </div>
                                <h3 class="fs-20"><a href="${event.permalink}">${event.title}</a></h3>
                            </div>
                            <div class="wp-events-filter__event-excerpt">
                                ${event.excerpt}
                            </div>
                            <a class="wp-events-filter__permalink" href="${event.permalink}"><span>Read More</span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none"> <path d="M3.718 12.4162L11.2837 8.28013V6.72973L3.718 2.59363L3.7168 4.05853L9.8794 7.50493L3.7168 10.9513L3.718 12.4162Z" fill="#009EC8"/> </svg> </a>
                        </div>

                    </div>
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
                this.countDisplay.text(`Showing ${start} - ${end} events, total ${total} events`);
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
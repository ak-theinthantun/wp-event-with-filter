<div class="wp-events-filter" data-per-page="<?= esc_attr($atts['per_page']) ?>">

    <div class="filter-col">

        <div class="wp-events-filter__form form-styles">

            <div class="wp-events-filter__search mb-12">
                <label for="search" class="fs-20" style="font-weight: 500;"><?= esc_html('Search', 'wp-events-filter') ?></label>
                <div class="input-group flex mt-10" style="position: relative">
                    <input type="text" class="wp-events-filter__search-input" name="search"
                        placeholder="Search..." />
                    <img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/search-icon.svg' ?>" class="search-icon" alt="">
                </div>
                <button id="filter-mobile-trigger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"> <path d="M21.25 12.5H8.895M4.534 12.5H2.75M4.534 12.5C4.534 11.9218 4.76368 11.3673 5.17251 10.9585C5.58134 10.5497 6.13583 10.32 6.714 10.32C7.29217 10.32 7.84666 10.5497 8.25549 10.9585C8.66432 11.3673 8.894 11.9218 8.894 12.5C8.894 13.0782 8.66432 13.6327 8.25549 14.0415C7.84666 14.4503 7.29217 14.68 6.714 14.68C6.13583 14.68 5.58134 14.4503 5.17251 14.0415C4.76368 13.6327 4.534 13.0782 4.534 12.5ZM21.25 19.107H15.502M15.502 19.107C15.502 19.6853 15.2718 20.2404 14.8628 20.6494C14.4539 21.0583 13.8993 21.288 13.321 21.288C12.7428 21.288 12.1883 21.0573 11.7795 20.6485C11.3707 20.2397 11.141 19.6852 11.141 19.107M15.502 19.107C15.502 18.5287 15.2718 17.9746 14.8628 17.5657C14.4539 17.1567 13.8993 16.927 13.321 16.927C12.7428 16.927 12.1883 17.1567 11.7795 17.5655C11.3707 17.9743 11.141 18.5288 11.141 19.107M11.141 19.107H2.75M21.25 5.89301H18.145M13.784 5.89301H2.75M13.784 5.89301C13.784 5.31484 14.0137 4.76035 14.4225 4.35152C14.8313 3.94269 15.3858 3.71301 15.964 3.71301C16.2503 3.71301 16.5338 3.7694 16.7983 3.87896C17.0627 3.98851 17.3031 4.14909 17.5055 4.35152C17.7079 4.55395 17.8685 4.79427 17.9781 5.05876C18.0876 5.32325 18.144 5.60673 18.144 5.89301C18.144 6.17929 18.0876 6.46277 17.9781 6.72726C17.8685 6.99175 17.7079 7.23207 17.5055 7.43451C17.3031 7.63694 17.0627 7.79751 16.7983 7.90707C16.5338 8.01663 16.2503 8.07301 15.964 8.07301C15.3858 8.07301 14.8313 7.84333 14.4225 7.43451C14.0137 7.02568 13.784 6.47118 13.784 5.89301Z" stroke="#575757" stroke-miterlimit="10" stroke-linecap="round"/> </svg>
                    <span>Filter</span>
                </button>
            </div>
            <div class="wp-events-filter__filters_wrapper">
                <div class="wp-events-filter__filters">
                    <div class="mobile-filter-header">
                        <div class="input-group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M21.25 12H8.895M4.534 12H2.75M4.534 12C4.534 11.4218 4.76368 10.8673 5.17251 10.4585C5.58134 10.0497 6.13583 9.82001 6.714 9.82001C7.29217 9.82001 7.84666 10.0497 8.25549 10.4585C8.66432 10.8673 8.894 11.4218 8.894 12C8.894 12.5782 8.66432 13.1327 8.25549 13.5415C7.84666 13.9503 7.29217 14.18 6.714 14.18C6.13583 14.18 5.58134 13.9503 5.17251 13.5415C4.76368 13.1327 4.534 12.5782 4.534 12ZM21.25 18.607H15.502M15.502 18.607C15.502 19.1853 15.2718 19.7404 14.8628 20.1494C14.4539 20.5583 13.8993 20.788 13.321 20.788C12.7428 20.788 12.1883 20.5573 11.7795 20.1485C11.3707 19.7397 11.141 19.1852 11.141 18.607M15.502 18.607C15.502 18.0287 15.2718 17.4746 14.8628 17.0657C14.4539 16.6567 13.8993 16.427 13.321 16.427C12.7428 16.427 12.1883 16.6567 11.7795 17.0655C11.3707 17.4743 11.141 18.0288 11.141 18.607M11.141 18.607H2.75M21.25 5.39301H18.145M13.784 5.39301H2.75M13.784 5.39301C13.784 4.81484 14.0137 4.26035 14.4225 3.85152C14.8313 3.44269 15.3858 3.21301 15.964 3.21301C16.2503 3.21301 16.5338 3.2694 16.7983 3.37896C17.0627 3.48851 17.3031 3.64909 17.5055 3.85152C17.7079 4.05395 17.8685 4.29427 17.9781 4.55876C18.0876 4.82325 18.144 5.10673 18.144 5.39301C18.144 5.67929 18.0876 5.96277 17.9781 6.22726C17.8685 6.49175 17.7079 6.73207 17.5055 6.93451C17.3031 7.13694 17.0627 7.29751 16.7983 7.40707C16.5338 7.51663 16.2503 7.57301 15.964 7.57301C15.3858 7.57301 14.8313 7.34333 14.4225 6.93451C14.0137 6.52568 13.784 5.97118 13.784 5.39301Z" stroke="#575757" stroke-miterlimit="10" stroke-linecap="round"/> </svg>
                            <span>Events</span> 
                        </div>
                        <button id="close-filter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M3 3L21 21M3 21L21 3" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg></button>
                    </div>
                    <div class="wp-events-filter__filter mb-12" style="background-color: #fff">
                        <label class="filter-header flex justify-between">
                            <span class="fs-20"><?= esc_html('Event', 'wp-events-filter') ?></span>
                            <img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/arrow-top-icon.svg' ?>" alt="">
                        </label> 
                        <div class="wp-events-filter__checkbox-group">
                            <?php foreach ($event_types as $type) : ?>
                            <div class="wp-events-filter__checkbox flex">
                                <input type="checkbox" name="event_type[]" value="<?php echo esc_attr($type->slug); ?>"
                                    id="event_type_<?php echo esc_attr($type->slug); ?>" />
                                <label for="event_type_<?php echo esc_attr($type->slug); ?>" class="flex justify-between w-full cursor-pointer">
                                    <span><?php echo esc_html($type->name); ?></span>
                                    <span>(<?= $type->count ?>)</span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="wp-events-filter__filter" style="background-color: #fff;">
                        <label class="filter-header flex justify-between">
                            <span class="fs-20"><?= esc_html('Category', 'wp-events-filter') ?></span>
                            <img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/arrow-top-icon.svg' ?>" alt="">
                        </label> 
                        <div class="wp-events-filter__checkbox-group">
                            <?php foreach ($event_categories as $category) : ?>
                            <div class="wp-events-filter__checkbox flex">
                                <input type="checkbox" name="event_category[]"
                                    value="<?php echo esc_attr($category->slug); ?>"
                                    id="event_category_<?php echo esc_attr($category->slug); ?>" />
                                <label for="event_category_<?php echo esc_attr($category->slug); ?>" class="flex justify-between w-full cursor-pointer">
                                    <span><?php echo esc_html($category->name); ?></span>
                                    <span>(<?= $category->count ?>)</span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <button type="button"
                            class="wp-events-filter__reset-button fs-16"><?= esc_html('Reset', 'wp-events-filter') ?></button>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="result-col">
        <div class="wp-events-filter__form flex justify-between">
            <div class="ordering flex">
                <div class="wp-events-filter__custom--select" data-name="sort">
                    <div class="wp-events-filter__selected-option">
                        <?php echo esc_html('Sort by latest', 'wp-events-filter') ?>
                    </div>
                    <div class="wp-events-filter__options">
                        <div class="wp-events-filter__option" data-value="newest"><?= esc_html('Sort by latest', 'wp-events-filter') ?></div>
                        <div class="wp-events-filter__option" data-value="oldest"><?= esc_html('Sort by oldest', 'wp-events-filter') ?></div>
                    </div>
                </div>
                <div class="wp-events-filter__custom--select" data-name="per_page">

                    <div class="wp-events-filter__selected-option">
                        <?php echo esc_html('6 items per page', 'wp-events-filter') ?>
                    </div>
                    <div class="wp-events-filter__options">
                        <div class="wp-events-filter__option" data-value="6"><?= esc_html('6 items per page', 'wp-events-filter') ?></div>
                        <div class="wp-events-filter__option" data-value="12"><?= esc_html('12 items per page', 'wp-events-filter') ?></div>
                        <div class="wp-events-filter__option" data-value="24"><?= esc_html('24 items per page', 'wp-events-filter') ?></div>
                    </div>
                    
                </div>
            </div>

            <div class="view-post">
                <button class="grid active" data-view="grid"><img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/grid.svg' ?>" alt="Grid Icon" class="grid-view"></button>
                <button class="list" data-view="list"><img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/list.svg' ?>" alt="list Icon" class="list-view"></button>
            </div>

        </div>
        <div class="wp-events-filter__count"></div>
        <div class="wp-events-filter__results">
            <div class="wp-events-filter__loading">
                <?= esc_html('loading...', 'wp-events-filter') ?>
            </div>
            <div class="wp-events-filter__events" data-view="grid"></div>
            <div class="wp-events-filter__pagination"></div>
        </div>
    </div>


</div>
<div class="wp-events-filter" data-per-page="<?= esc_attr($atts['per_page']) ?>">

    <div class="filter-col">

        <div class="wp-events-filter__form form-styles">

            <div class="wp-events-filter__search mb-12">
                <label for="search" class="fs-20" style="font-weight: 500;"><?= esc_html('Search', 'wp-events-filter') ?></label>
                <div class="input-group flex mt-10" style="position: relative">
                    <input type="text" class="wp-events-filter__search-input" name="search"
                        placeholder="Search events..." />
                    <img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/search-icon.svg' ?>" class="search-icon" alt="">
                </div>
            </div>

            <div class="wp-events-filter__filters">
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

    <div class="result-col">
        <div class="wp-events-filter__form flex justify-between">
            <div class="ordering">
                <div class="wp-events-filter__filter">
                    <select name="sort" id="sort" class="wp-events-filter__select">
                        <option value="newest"><?= esc_html('Sort by latest', 'wp-events-filter') ?></option>
                        <option value="oldest"><?= esc_html('Sort by oldest', 'wp-events-filter') ?></option>
                    </select>
                </div>
                <div class="wp-events-filter__filter">
                    <select name="per_page" id="per_page" class="wp-events-filter__select">
                        <option value="6" selected><?= esc_html('6 items per page', 'wp-events-filter') ?></option>
                        <option value="12"><?= esc_html('12 items per page', 'wp-events-filter') ?></option>
                        <option value="24"><?= esc_html('24 items per page', 'wp-events-filter') ?></option>
                    </select>
                </div>
            </div>

            <div class="view-post">
                <button><img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/grid.svg' ?>" alt="Grid Icon" class="grid-view"></button>
                <button><img src="<?= WP_EVENTS_FILTER_URL . 'public/imgs/list.svg' ?>" alt="list Icon" class="list-view"></button>
            </div>

        </div>
        <div class="wp-events-filter__count"></div>
        <div class="wp-events-filter__results">
            <div class="wp-events-filter__loading">
                <?= esc_html('loading...', 'wp-events-filter') ?>
            </div>
            <div class="wp-events-filter__events grid"></div>
            <div class="wp-events-filter__pagination"></div>
        </div>
    </div>


</div>
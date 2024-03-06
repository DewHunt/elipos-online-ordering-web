<ul class="menu-category-list">
    <?php if (!empty($dealsCategories)): ?>
        <?php
            $dealsName = $product_object->get_offers_or_deals_name();
            $dealsId = str_replace(' ', '-', $dealsName);
        ?>
        <li class="category-list-item">
            <a class="nav-link" href="#category-id-<?= $dealsId ?>" data-collapse-id="categoryCollapseId<?= $dealsId ?>" data-heading-category-id="#headingCategory-<?= $dealsId ?>">
                <?= ucfirst($product_object->get_offers_or_deals_name()) ?>
            </a>
        </li>
    <?php endif ?>

    <?php if (!empty($categories)): ?>
        <?php
            $i = 1;
            $isOfferShowed = false;
            $currentDayName = strtolower(date('l'));
        ?>
        <?php foreach ($categories as $category): ?>
            <?php
                $availabilities = explode(',',$category->availability);
                // echo "<pre>"; print_r($availabilities);
            ?>
            <?php if (in_array($currentDayName,$availabilities)): ?>
                <li class="category-list-item" style="margin: 2px 0px 2px 0px; width: 100%;">
                    <a class="nav-link" href="#category-id-<?= $category->categoryId ?>" data-collapse-id="categoryCollapseId<?= $category->categoryId ?>"data-heading-category-id="#headingCategory-<?= $category->categoryId ?>">
                        <span class="<?= $category->isHighlight == 1 ? 'category-highlighted-text' : '' ?>" style="background-color: <?= $category->isHighlight == 1 ? $category->highlight_color : '' ?>"><?= ($category->categoryName) ?></span>
                    </a>
                </li>                
            <?php endif ?>
            <?php $i++; ?>
        <?php endforeach ?>
    <?php endif ?>
</ul>
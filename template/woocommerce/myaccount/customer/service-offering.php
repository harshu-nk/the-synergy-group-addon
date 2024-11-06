<?php
// print_r($business);
?>
<form class="light-style input-small" enctype="multipart/form-data" method="post">
  <input type="hidden" name="form-type" value="business-profile">
  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/professional.svg" alt="professional details icon" />
        <h5><?php _e('Professional Details', 'the-synergy-group-addon'); ?></h5>
      </div>
    </div>

    <div class="block-lines media-full">

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><strong><?php _e('Business Name', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right input-field">
          <input type="text" id="business-name" name="business-name" value="<?php echo isset($business['business_name']) ? $business['business_name'] : '' ?>">
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><strong><?php _e('Industry', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right input-field">
          <div class="select">
            <p class="select-name"><span><?php _e('Coaching', 'the-synergy-group-addon'); ?></span></p>
            <input type="hidden" id="industry" name="industry" value="<?php echo isset($business['industry']) ? $business['industry'] : '' ?>" />
            <ul class="select-list hauto">
              <li>Coaching</li>
              <li>Point 2</li>
              <li>Point 3</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><strong><?php _e('Years of Experience', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right input-field">
          <div class="select">
            <p class="select-name"><span>7</span></p>
            <input type="hidden" id="years-experience" name="years-experience" value="<?php echo isset($business['exp_years']) ? $business['exp_years'] : '' ?>" />
            <ul class="select-list">
              <li>1</li>
              <li>2</li>
              <li>3</li>
              <li>4</li>
              <li>5</li>
              <li>6</li>
              <li>7</li>
              <li>8</li>
              <li>9</li>
              <li>10</li>
              <li>More than 10</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="block-line edit-elem-block big-line spb">
        <div class="line-left">
          <p><strong><?php _e('Logo', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right edit-parent va">
          <?php if (isset($business['company_logo'])) { ?>
            <div class="selected-logo edit-elem">
              <img class="hidable-value" src="<?php echo $business['company_logo']; ?>" alt="<?php echo isset($business['business_name']) ? $business['business_name'] : '' ?>" />
            </div>
          <?php } ?>
          <div class="btn-block media400-w100">
            <input type="file" class="editable-input" name="company_logo" id="company_logo_input">
            <a href="#" class="btn style2 company_logo_btn change-btn"><?php _e('change', 'the-synergy-group-addon'); ?></a>
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><strong><?php _e('Description', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right edit-parent line-w100 bordert va">
          <div class="left-flex">
            <textarea name="company-description" class="editable-inputz" value="<?php echo isset($business['company_description']) && !empty($business['company_description']) ? $business['company_description'] : '' ?>"><?php echo isset($business['company_description']) && !empty($business['company_description']) ? $business['company_description'] : '' ?></textarea>
          </div>
          <div class="btn-block">
            <a href="#" class="btn style2 change-btn"><?php _e('change', 'the-synergy-group-addon'); ?></a>
          </div>
        </div>
      </div>

      <div class="block-line edit-elem-block big-line spb">
        <div class="line-left">
          <p><strong><?php _e('Website', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right edit-parent edit-media-full va">
          <div class="edit-elem edit-link align-right">
            <p>
              <input type="url" name="website" id="website" class="editable-input" value="<?php echo isset($business['business_website']) ? $business['business_website'] : '' ?>" placeholder="https://www.procoaching.com">
              <a href="<?php echo isset($business['business_website']) ? $business['business_website'] : '' ?>" class="blue-link hidable-value"><?php echo isset($business['business_website']) ? $business['business_website'] : '' ?></a>
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn style2 change-btn"><?php _e('change', 'the-synergy-group-addon'); ?></a>
          </div>
        </div>
      </div>

      <div class="btn-block fl-end mt25">
        <button type="submit" class="btn btn-small minw"><?php _e('SAVE', 'the-synergy-group-addon'); ?></button>
      </div>
    </div>
  </div>
</form>



<form class="light-style input-small" enctype="multipart/form-data" method="post" id="manage-service-form">
  <input type="hidden" name="form-type" value="service-offering">
  <input type="hidden" id="product-id" name="product-id" value=""> <!-- For editing existing product -->

  <div class="account-text-block">
    <div class="account-title-block media-full spb">
      <div class="title-content va">
        <img width="53" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/manage_services.svg" alt="manage services icon" />
        <h5><?php _e('Manage Services', 'the-synergy-group-addon'); ?></h5>
      </div>
      <div class="line-right input-field width2">
        <div class="select">
          <p class="select-name" id="tsg-selected-service"><span>Select Service</span></p>
          <input type="hidden" id="selected-service" name="selected-service" value="" />
          <ul class="select-list hauto" id="user-products">
            <li data-id="create-new">Create New</li>
            <?php 
            //foreach ($products as $product) {
              //echo "<li data-value='{$product['id']}'>{$product['title']}</li>";
            //} ?></ul>
        </div>
      </div>
    </div>

    <div class="block-lines small-lines media-full">
      <div class="block-line spb small-line">
        <div class="line-right va btns-part">
          <div class="btn-block">
            <a href="#" class="btn style2 tsg-edit-service-btn">edit</a>
          </div>
          <div class="btn-block">
            <a href="#" class="btn style2 tsg-delete-service-btn" id="tsg-delete-service">delete</a>
          </div>
        </div>
      </div>
    </div>
    <p class="mt25"><strong><?php _e('Service Details', 'the-synergy-group-addon'); ?>:</strong></p>
    <div class="block-lines">
      <div class="block-line edit-parent spb">
        <div class="line-left">
          <p><?php _e('Name', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right">
          <input type="text" name="service-name" id="service-name" placeholder="Super Service">
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><?php _e('Long Description', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right textarea-field long-textarea">
          <textarea id="long-desc" name="long-description" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit, sed do eiusmod tempor incididunt consectetur adipiscing elit, sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit, sed do eiusmod tempor incididunt consectetur adipiscing elit, sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor "></textarea>
        </div>
      </div>

      <div class="block-line spb line-continue">
        <div class="line-left">
          <p><?php _e('Short Description', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right textarea-field">
          <textarea id="short-desc" name="short-description" placeholder="Short Description"></textarea>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><?php _e('Pricing', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right qty-field">
          <div class="line-right input-field">
            <input type="number" placeholder="100" id="pricing-units" name="product-price">
          </div>
          <div class="items pad10 tsg-sf-and-chf-wrapper">
            <div class="item w2">
              <div class="itemr">
                    <input type="number" id="pricing-sf" name="pricing-sf" placeholder="SF 20%" min="1" class="quantity-selector quantity-input">
              </div>
            </div>
            <div class="item w2">
              <div class="itemr">
                <input type="number" id="pricing-chf" name="pricing-chf" min="1" max="75" placeholder="CHF 80%">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><?php _e('Category', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right input-field">
          <select id="taxonomy-select" style="width:100%" name="selected-category"></select>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><?php _e('Activity Type', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right input-field">
          <div class="select">
            <p class="select-name"><span>Activity</span></p>
            <input type="hidden" id="activity-type" name="activity-type" value="Activity" />
            <ul class="select-list hauto">
              <li>Activity</li>
              <li>Point 2</li>
              <li>Point 3</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><?php _e('Main Picture', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right line-w100">
          <div class="main-picture-block">
            <div class="items pictures pad10">
              <div class="item w3">
                <div class="itemr">
                  <img class="uploaded-picture opt" id="main-image"/>
                </div>
              </div>
            </div>
            <div class="btn-block">
              <input type="file" name="service-image" id="service-image" style="display: none;">
              <a href="#" class="btn style2" id="service-image-btn">change</a>
            </div>
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><?php _e('Additional Pictures', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right line-w100">
          <div class="items pictures pad10">
            <div class="item w3">
              <div class="itemr">
                <img class="uploaded-picture opt" />
              </div>
            </div>
          </div>
          <div class="btn-block fl-end mt20">
            <input type="file" name="service-gallery" id="service-gallery" multiple style="display: none;">
            <a href="#" class="btn style2" id="service-gallery-btn">change</a>
          </div>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><strong><?php _e('Service Performance Analytics', 'the-synergy-group-addon'); ?></strong></p>
        </div>
        <div class="line-right input-field">
          <div class="select">
            <p class="select-name"><span>Enabled</span></p>
            <input type="hidden" id="performance-analytics" name="performance-analytics" value="Enabled" />
            <ul class="select-list hauto">
              <li>Enabled</li>
              <li>Disabled</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><?php _e('Views', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>375</strong></p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><?php _e('Bookings', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>14</strong></p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p><?php _e('Earnings', 'the-synergy-group-addon'); ?></p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>CHF 400 + SF 1,200</strong></p>
        </div>
      </div>
    </div>
  </div>

  <div class="btn-block fl-end mt25">
    <button type="submit" class="btn btn-small minw"><?php _e('SAVE', 'the-synergy-group-addon'); ?></button>
  </div>

</form>
<!-- <form id="manage-service-form" class="light-style input-small" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form-type" value="service-offering">

    <div class="account-title-block media-full spb">
        <div class="line-right input-field width2">
            <div class="select">
                <p class="select-name"><span>Select Service</span></p>
                <input type="hidden" id="selected-product" name="selected-product" value="">
                <ul class="select-list hauto" id="user-products">
                </ul>
            </div>
        </div>
    </div>

    <div class="block-lines">
        <div class="block-line spb">
            <div class="line-left"><p>Name</p></div>
            <div class="line-right"><input type="text" name="product-name" id="product-name" placeholder="Service Name"></div>
        </div>

        <div class="block-line spb">
            <div class="line-left"><p>Long Description</p></div>
            <div class="line-right textarea-field long-textarea">
                <textarea id="product-long-desc" name="product-long-desc"></textarea>
            </div>
        </div>

        <div class="block-line spb">
            <div class="line-left"><p>Price</p></div>
            <div class="line-right">
                <input type="number" name="product-price" id="product-price" placeholder="Product Price">
            </div>
        </div>

        <div class="block-line spb">
            <div class="line-left"><p>Gallery</p></div>
            <div class="line-right">
                <div id="gallery-upload" class="dropzone"></div>
            </div>
        </div>
    </div>

    <div class="btn-block">
        <button type="submit" class="btn">Save Product</button>
        <button id="delete-product" class="btn style2">Delete Product</button>
    </div>
</form> -->

<?php ?>
<form class="light-style input-small">

<div class="account-text-block">
  <div class="account-title-block spb">
    <div class="title-content va">
      <img width="52" src="img/account/professional.svg" alt="professional details icon" />
      <h5>Professional Details</h5>
    </div>
  </div>

  <div class="block-lines media-full">

    <div class="block-line spb small-line">
      <div class="line-left">
        <p><strong>Business Name</strong></p>
      </div>
      <div class="line-right input-field">
        <input type="text" id="business-name">
      </div>
    </div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p><strong>Industry</strong></p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>Coaching</span></p>
          <input type="hidden" id="industry" name="industry" value="Coaching" />
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
        <p><strong>Years of Experience</strong></p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>7</span></p>
          <input type="hidden" id="years-experience" name="years-experience" value="7" />
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
        <p><strong>Logo</strong></p>
      </div>
      <div class="line-right va">
        <div class="selected-logo edit-elem">
          <img src="img/account/company_logo.png" alt="company logotype" />
        </div>
        <div class="btn-block media400-w100">
          <a href="#" class="btn style2">change</a>
        </div>
      </div>
    </div>

    <div class="block-line spb">
      <div class="line-left">
        <p><strong>Description</strong></p>
      </div>
      <div class="line-right line-w100 bordert va">
        <div class="left-flex">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit, sed do eiusmod tempor incididunt consectetur adipiscing elit, sed do eiusmod tempor incididunt...</p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn style2">change</a>
        </div>
      </div>
    </div>

    <div class="block-line edit-elem-block big-line spb">
      <div class="line-left">
        <p><strong>Website</strong></p>
      </div>
      <div class="line-right edit-media-full va">
        <div class="edit-elem edit-link align-right">
          <p><a href="http://www.Procoaching.com" class="blue-link">www.Procoaching.com</a></p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn style2">change</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="account-text-block">
  <div class="account-title-block media-full spb">
    <div class="title-content va">
      <img width="53" src="img/account/manage_services.svg" alt="manage services icon" />
      <h5>Manage Services</h5>
    </div>
    <div class="line-right input-field width2">
      <div class="select">
        <p class="select-name"><span>Select Service</span></p>
        <input type="hidden" id="selected-service" name="selected-service" value="" />
        <ul class="select-list hauto">
          <li>Service 1</li>
          <li>Service 2</li>
          <li>Service 3</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="block-lines small-lines media-full">

    <div class="block-line spb small-line">
      <div class="line-left">
        <p><strong>Manage</strong></p>
      </div>
      <div class="line-right va btns-part">
        <div class="btn-block">
          <a href="#" class="btn style2">edit</a>
        </div>
        <div class="btn-block">
          <a href="#" class="btn style2">delete</a>
        </div>
      </div>
    </div>
  </div>

  <p class="mt25"><strong>Service Details:</strong></p>
  <div class="block-lines">

    <div class="block-line spb">
      <div class="line-left">
        <p>Name</p>
      </div>
      <div class="line-right">
        <p>Super Service</p>
      </div>
    </div>

    <div class="block-line spb">
      <div class="line-left">
        <p>Long Description</p>
      </div>
      <div class="line-right textarea-field long-textarea">
        <textarea id="long-desc" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit, sed do eiusmod tempor incididunt consectetur adipiscing elit, sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit, sed do eiusmod tempor incididunt consectetur adipiscing elit, sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor "></textarea>
      </div>
    </div>

    <div class="block-line spb line-continue">
      <div class="line-left">
        <p>Short Description</p>
      </div>
      <div class="line-right textarea-field">
        <textarea id="long-desc" placeholder="Short Description"></textarea>
      </div>
    </div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p>Pricing</p>
      </div>
      <div class="line-right qty-field">
        <div class="items pad10">
          <div class="item w2">
            <div class="itemr">
              <div class="qtydiv">
                <div class="qtybox">
                  <div class="btnqty qtyplus">
                    <img src="img/account/qty_top.svg" alt="plus" />
                  </div>
                  <input type="text" id="quantity" name="quantity" value="CHF 20%" min="1" class="quantity-selector quantity-input">
                  <div class="btnqty qtyminus">
                    <img src="img/account/qty_bottom.svg" alt="minus" />
                  </div>
                </div>
              </div>                              
            </div>
          </div>
          <div class="item w2">
            <div class="itemr">
              <input type="text" id="pricing-sf" placeholder="CHF 80%">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p>Category</p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>Coaching</span></p>
          <input type="hidden" id="selected-category" name="selected-category" value="Coaching" />
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
        <p>Activity Type</p>
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
        <p>Main Picture</p>
      </div>
      <div class="line-right line-w100">
        <div class="main-picture-block">
          <div class="items pictures pad10">
            <div class="item w3">
              <div class="itemr">
                <div class="uploaded-picture opt"></div>
              </div>
            </div>
          </div>
          <div class="btn-block">
            <a href="#" class="btn style2">change</a>
          </div>
        </div>
      </div>
    </div>

    <div class="block-line spb">
      <div class="line-left">
        <p>Additional Pictures</p>
      </div>
      <div class="line-right line-w100">
        <div class="items pictures pad10">
          <div class="item w3">
            <div class="itemr">
              <div class="uploaded-picture opt"></div>
            </div>
          </div>
          <div class="item w3">
            <div class="itemr">
              <div class="uploaded-picture opt"></div>
            </div>
          </div>
          <div class="item w3">
            <div class="itemr">
              <div class="uploaded-picture opt"></div>
            </div>
          </div>
          <div class="item w3">
            <div class="itemr">
              <div class="uploaded-picture opt"></div>
            </div>
          </div>
          <div class="item w3">
            <div class="itemr">
              <div class="uploaded-picture opt"></div>
            </div>
          </div>
          <div class="item w3">
            <div class="itemr">
              <div class="uploaded-picture opt"></div>
            </div>
          </div>
        </div>
        <div class="btn-block fl-end mt20">
          <a href="#" class="btn style2">change</a>
        </div>
      </div>
    </div>

    <div class="block-line spb small-line">
      <div class="line-left">
        <p><strong>Service Performance Analytics</strong></p>
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
        <p>Views</p>
      </div>
      <div class="line-right">
        <p class="main-val2"><strong>375</strong></p>
      </div>
    </div>

    <div class="block-line spb">
      <div class="line-left">
        <p>Bookings</p>
      </div>
      <div class="line-right">
        <p class="main-val2"><strong>14</strong></p>
      </div>
    </div>

    <div class="block-line spb">
      <div class="line-left">
        <p>Earnings</p>
      </div>
      <div class="line-right">
        <p class="main-val2"><strong>CHF 400 + SF 1,200</strong></p>
      </div>
    </div>
  </div>
</div>

<div class="btn-block fl-end mt25">
  <a href="#" class="btn btn-small minw">SAVE</a>
</div>

</form>
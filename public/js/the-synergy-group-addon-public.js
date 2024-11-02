jQuery(document).ready(function ($) {
   $(".edit-pencil:not(.bio-edit-pencil)").click(function (e) {
      e.preventDefault();
      $(this).toggleClass("active");
      const parentRow = $(this).closest(".line-row"); 

      // if (parentRow.find(".form-curr-value").is(":visible")) {
      //    parentRow.find(".form-curr-value").hide();
      //    parentRow.find(".form-row").show().addClass("active");
      // } else {
      //    parentRow.find(".form-curr-value").show();
      //    parentRow.find(".form-row").hide().removeClass("active");
      // }
      parentRow.find(".form-curr-value").toggleClass("tsg-entry-hidden");
      parentRow.find(".form-row").toggleClass("tsg-entry-hidden");
   });

   $(".bio-edit-pencil").click(function (e) {
      e.preventDefault();
      if ($(".bio").find(".form-curr-value").is(":visible")) {
         $(".bio").find(".form-curr-value").hide();
         
         $(".bio").find(".form-row").show().addClass("active");
      } else {
         $(".bio").find(".form-curr-value").show();
         $(".bio").find(".form-row").hide().removeClass("active");
      }
   });

   $("#tsg-add-certificate").click(function(e){
      e.preventDefault();
      $(".tsg-certificate-wrapper").toggleClass("tsg-entry-hidden");
   });

   //user certificate control
   var certificates = [];
   $('#tsg-user-add-certificate-btn').on('click', function() {
      var certificateText = $('#certificate-input').val().trim();

      if (certificateText === "") {
          $('#tsg-certificate-error-message').show(); 
          return; 
      } else {
          $('#tsg-certificate-error-message').hide(); 
      }

      certificates.push(certificateText);
      var certificateId = 'certificate-' + certificates.length;

      var newCertificate = `
            <div class="item w2" id="${certificateId}">
                <div class="itemr">
                    <div class="award-block tc">
                        <a href="#" class="block-edit delete-certificate-btn" data-id="${certificateId}" data-text="${certificateText}"><img src="https://thesynergygroup.ch/wp-content/plugins/the-synergy-group-addon/public/img/account/edit.svg" alt="edit icon"></a>
                        <div class="award-icon">
                            <img src="https://thesynergygroup.ch/wp-content/plugins/the-synergy-group-addon/public/img/account/award.svg" alt="award icon">
                        </div>
                        <p class="fs-20 mt18 tsg-certificate-name">${certificateText}</p>
                    </div>
                </div>
            </div>
        `;

      $('#tsg-certificate-container').append(newCertificate);

      $('#certificate-input').val('');
      $(".tsg-certificate-wrapper").addClass("tsg-entry-hidden");
   });

   $('#tsg-certificate-container').on('click', '.delete-certificate-btn', function(e) {
      e.preventDefault();
      var certificateId = $(this).data('id');
      var certificateText = $(this).data('text');

      $('#' + certificateId).remove();

      // Find the certificate text in the array and remove it
      certificates = certificates.filter(function(text) {
         return text !== certificateText;
      });

      console.log(certificates); 
   });

   $(".user-withdraw-btn").on("click", function (e) {
      e.preventDefault();
      $(this).parents(".input-field").find(".user-withdraw-form").toggle();
   });

   $(".customer-buy-sf-btn").on("click", function (e) {
      e.preventDefault();
      $(this).parents(".width-field").find("#customer-buy-sf-form").toggle();
   });

   $(".customer-sf-history-btn").on("click", function (e) {
      e.preventDefault();
      $("#customer-sf-history").toggle();
   });

   $(".company_logo_btn").on("click", function (e) {
      e.preventDefault();
      $("#company_logo_input").click();
   });

   $(".change-btn").on("click", function (e) {
      e.preventDefault();
      $(this).parents(".edit-parent").find(".editable-input").toggle();
      $(this).parents(".edit-parent").find(".hidable-value").toggle();
   });

   $("#taxonomy-select").select2({
      placeholder: "Select an option",
      ajax: {
         url: tsg_public_ajax.ajax_url,
         dataType: "json",
         delay: 250,
         data: function (params) {
            return {
               action: "get_taxonomy_terms",
               search: params.term,
               taxonomy: "product_cat",
            };
         },
         processResults: function (data) {
            return {
               results: $.map(data, function (item) {
                  return {
                     //   id: item.id,
                     id: item.slug,
                     text: item.text,
                  };
               }),
            };
         },
         cache: true,
      },
      minimumInputLength: 2, // Start searching after 2 characters
   });

   //   Services Endpoint
   // Load user-owned products on page load
   $.ajax({
      url: tsg_public_ajax.ajax_url,
      type: "POST",
      data: { action: "get_user_products" },
      success: function (response) {
         if (response.success) {
            var products = response.data;
            $.each(products, function (index, product) {
               $("#user-products").append('<li data-id="' + product.id + '">' + product.title + "</li>");
            });
         }
      },
   });

   // When a product is selected, populate the form fields
   $("#user-products").on("click", "li", function () {
      var productId = $(this).data("id");
      $("#selected-product").val(productId);

      // Fetch product details
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: { action: "get_product_details", product_id: productId },
         success: function (response) {
            if (response.success) {
               var product = response.data;
               $("#product-id").val(product.id);
               $("#service-name").val(product.name);
               $("#long-desc").val(product.long_description);
               $("#short-desc").val(product.short_description);
               // $("#product-price").val(product.chf_price);
               $("#pricing-units").val(product.pricing_units);
               $("#pricing-sf").val(product.pricing_sf);
               $("#pricing-chf").val(product.pricing_chf);
               $("#taxonomy-select").val(product.category);
               $("#activity-type").val(product.activity);
               $("#main-imagee").val(product.main_image);
               // $('#activity-type').val(product.gallery); // Load gallery images (implement your logic here)
            }
         },
      });
   });

   // Handle form submission (create/edit product)
   $("#manage-service-form").on("submit", function (e) {
      e.preventDefault();
      var formData = $(this).serialize();

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: formData + "&action=save_product",
         success: function (response) {
            if (response.success) {
               alert("Product saved successfully!");
               // Refresh the product list or other actions
            }
         },
      });
   });

   // Handle product deletion
   $("#delete-product").on("click", function (e) {
      e.preventDefault();
      var productId = $("#selected-product").val();

      if (confirm("Are you sure you want to delete this product?")) {
         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: "POST",
            data: { action: "delete_product", product_id: productId },
            success: function (response) {
               if (response.success) {
                  alert("Product deleted successfully!");
                  // Refresh the form or other actions
               }
            },
         });
      }
   });

   // Initialize Dropzone for gallery upload
   // Dropzone.autoDiscover = false;
   if ($("#gallery-upload").length > 0) {
      var myDropzone = new Dropzone("#gallery-upload", {
         url: tsg_public_ajax.ajax_url + "?action=upload_gallery_images", // Handle image upload
         paramName: "file", // File input name
         maxFilesize: 2, // MB
         acceptedFiles: "image/*",
         success: function (file, response) {
            // Handle successful upload (e.g., add image to the gallery field)
         },
      });
   }

   // Transactions Tab
   $("#purchase-datepicker")
      .datepicker({
         autoclose: true,
         todayHighlight: true,
         clearBtn: true,
         format: "yyyy-mm-dd",
         onSelect: function (value, date) {
            if (value) {
               $("#selected-purchase-date").text(value);
               $.ajax({
                  url: tsg_public_ajax.ajax_url,
                  type: "POST",
                  data: {
                     action: "fetch_user_orders",
                     selected_date: value,
                  },
                  success: function (response) {
                     var $purchasedProducts = $(".purchased-products");
                     $purchasedProducts.empty();

                     if (response.success && response.data.length > 0) {
                        // Use the template to create multiple order divs
                        response.data.forEach(function (order) {
                           var $orderTemplate = $(
                              '<div class="block-lines purchased-product-item">' +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Service Name</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-name"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Service Provider</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-author">Synergy</strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Purchase Date</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-date">2024/04/04</strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Cost</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-cost">1,450 (CHF 360 + SF 1,090)</strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Rating</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-rating"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Review</p>" +
                                 "</div>" +
                                 '<div class="line-right textarea-field">' +
                                 '<textarea class="review-input" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit,"></textarea>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<a href="#" class="btn style2 save-review" data-product="">Save</a>' +
                                 "</div>" +
                                 "</div>"
                           );

                           $orderTemplate.find(".purchase-product-name").text(order.product_name);
                           $orderTemplate.find(".purchase-product-author").text(order.product_author);
                           $orderTemplate.find(".purchase-product-date").text(order.order_date);
                           $orderTemplate.find(".purchase-product-cost").text(order.order_total);
                           $orderTemplate.find(".purchase-product-rating").html(order.rating);
                           $orderTemplate.find(".save-review").data("product", order.product_id);

                           $purchasedProducts.append($orderTemplate);
                        });
                     } else {
                        $purchasedProducts.html('<div class="no-orders"><p>No orders found for the selected date.</p></div>');
                     }
                  },
                  error: function () {
                     $(".purchased-products").html(
                        '<div class="error-message"><p>An error occurred while fetching the orders. Please try again later.</p></div>'
                     );
                  },
               });
            }
         },
         todayBtn: "linked",
         startView: 0,
         maxViewMode: 0,
         minViewMode: 0,
      })
      .hide()
      .click(function () {
         $(this).hide();
      });

   $("#selected-purchase-date").on("click", function (e) {
      $("#purchase-datepicker").toggle();
   });

   $(document).on("click", ".save-review", function (e) {
      e.preventDefault();
      let review = $(this).parents(".purchased-product-item").find(".review-input").val();
      console.log(review);
   });

   $("#sales-datepicker")
      .datepicker({
         autoclose: true,
         todayHighlight: true,
         clearBtn: true,
         format: "yyyy-mm-dd",
         onSelect: function (value, date) {
            if (value) {
               $("#selected-sales-date").text(value);
               $.ajax({
                  url: tsg_public_ajax.ajax_url,
                  type: "POST",
                  data: {
                     action: "fetch_user_sales",
                     selected_date: value,
                  },
                  success: function (response) {
                     var $purchasedProducts = $(".sales-products");
                     $purchasedProducts.empty();

                     if (response.success && response.data.length > 0) {
                        // Use the template to create multiple order divs
                        response.data.forEach(function (order) {
                           var $orderTemplate = $(
                              '<div class="block-lines purchased-product-item">' +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Service Name</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-name"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Service Provider</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-author">Synergy</strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Purchase Date</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-date">2024/04/04</strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Cost</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-cost">1,450 (CHF 360 + SF 1,090)</strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Rating</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="purchase-product-rating"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Review</p>" +
                                 "</div>" +
                                 "</div>" +
                                 "</div>"
                           );

                           $orderTemplate.find(".purchase-product-name").text(order.product_name);
                           $orderTemplate.find(".purchase-product-author").text(order.product_author);
                           $orderTemplate.find(".purchase-product-date").text(order.order_date);
                           $orderTemplate.find(".purchase-product-cost").text(order.order_total);
                           $orderTemplate.find(".purchase-product-rating").html(order.rating);
                           $orderTemplate.find(".save-review").data("product", order.product_id);

                           $purchasedProducts.append($orderTemplate);
                        });
                     } else {
                        $purchasedProducts.html('<div class="no-orders"><p>No orders found for the selected date.</p></div>');
                     }
                  },
                  error: function () {
                     $(".sales-products").html(
                        '<div class="error-message"><p>An error occurred while fetching the orders. Please try again later.</p></div>'
                     );
                  },
               });
            }
         },
         todayBtn: "linked",
         startView: 0,
         maxViewMode: 0,
         minViewMode: 0,
      })
      .hide()
      .click(function () {
         $(this).hide();
      });

   $("#selected-sales-date").on("click", function (e) {
      $("#sales-datepicker").toggle();
   });

   $("#affiliate-datepicker")
      .datepicker({
         autoclose: true,
         todayHighlight: true,
         clearBtn: true,
         format: "yyyy-mm-dd",
         onSelect: function (value, date) {
            if (value) {
               $("#selected-aff-date").text(value);
               $.ajax({
                  url: tsg_public_ajax.ajax_url,
                  type: "POST",
                  data: {
                     action: "fetch_user_sales",
                     selected_date: value,
                  },
                  success: function (response) {
                     var $affiliateProducts = $(".affiliate-products");
                     $affiliateProducts.empty();

                     if (response.success && response.data.length > 0) {
                        // Use the template to create multiple order divs
                        response.data.forEach(function (order) {
                           var $orderTemplate = $(
                              '<div class="block-lines media-full affiliate-product-item">' +
                                  '<div class="block-line spb">' +
                                      '<div class="line-left">' +
                                          '<p>Date</p>' +
                                      '</div>' +
                                      '<div class="line-right">' +
                                          '<p><strong class="date"></strong></p>' +
                                      '</div>' +
                                  '</div>' +
                                  '<div class="block-line spb">' +
                                      '<div class="line-left">' +
                                          '<p>Referred Member Name</p>' +
                                      '</div>' +
                                      '<div class="line-right">' +
                                          '<p><strong class="ref-by"></strong></p>' +
                                      '</div>' +
                                  '</div>' +
                                  '<div class="block-line spb">' +
                                      '<div class="line-left">' +
                                          '<p>Service/Product Purchased</p>' +
                                      '</div>' +
                                      '<div class="line-right">' +
                                          '<p><strong class="product-name"></strong></p>' +
                                      '</div>' +
                                  '</div>' +
                                  '<div class="block-line spb">' +
                                      '<div class="line-left">' +
                                          '<p>Transaction Amount (CHF)</p>' +
                                      '</div>' +
                                      '<div class="line-right">' +
                                          '<p><strong class="product-pricing"></strong></p>' +
                                      '</div>' +
                                  '</div>' +
                                  '<div class="block-line spb">' +
                                      '<div class="line-left">' +
                                          '<p>Affiliate Fee Earned (CHF)</p>' +
                                      '</div>' +
                                      '<div class="line-right">' +
                                          '<p><strong class="aff_chf"></strong></p>' +
                                      '</div>' +
                                  '</div>' +
                                  '<div class="block-line spb">' +
                                      '<div class="line-left">' +
                                          '<p>Affiliate Fee Earned (SF)</p>' +
                                      '</div>' +
                                      '<div class="line-right">' +
                                          '<p><strong class="aff_sf"></strong></p>' +
                                      '</div>' +
                                  '</div>' +
                              '</div>'
                          );
  
                          $orderTemplate.find('.date').text(order.order_date);
                          $orderTemplate.find('.ref-by').text(order.ref);
                          $orderTemplate.find('.product-name').text(order.product_name);
                          $orderTemplate.find('.product-pricing').text(order.main_cost);
                          $orderTemplate.find('.aff_chf').text('CHF ' + parseFloat(order.chf_cost));
                          $orderTemplate.find('.aff_sf').text('SF ' + parseFloat(order.sf_cost));
  
                          $affiliateProducts.append($orderTemplate);
                        });
                     } else {
                        $purchasedProducts.html('<div class="no-orders"><p>No orders found for the selected date.</p></div>');
                     }
                  },
                  error: function () {
                     $(".affiliate-products").html(
                        '<div class="error-message"><p>An error occurred while fetching the orders. Please try again later.</p></div>'
                     );
                  },
               });
            }
         },
         todayBtn: "linked",
         startView: 0,
         maxViewMode: 0,
         minViewMode: 0,
      })
      .hide()
      .click(function () {
         $(this).hide();
      });

      $("#selected-aff-date").on("click", function (e) {
         $("#affiliate-datepicker").toggle();
      });
});

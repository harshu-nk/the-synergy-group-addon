jQuery(document).ready(function ($) {
   $(".edit-pencil:not(.bio-edit-pencil)").click(function (e) {
      e.preventDefault();
      $(this).addClass("tsg-entry-hidden");
      $(this).closest(".tsg-entry-block").find(".tsg-save-profile").removeClass("tsg-entry-hidden");
      const parentRow = $(this).closest(".line-row");
      const parentDiv = $(this).closest(".block-line");

      parentDiv.addClass("active");
      parentRow.find(".form-curr-value").addClass("tsg-entry-hidden");
      parentRow.find(".form-row").removeClass("tsg-entry-hidden");
   });

   $(".bio-edit-pencil").click(function (e) {
      e.preventDefault();
      var $parent = $(this).closest('.tsg-entry-block');
      var $section = $(this).closest('.tsg-entry-block-section');
   
      $(this).addClass("tsg-entry-hidden");
      $parent.find(".tsg-save-description").removeClass("tsg-entry-hidden");
      $section.find(".form-curr-value").addClass("tsg-entry-hidden");
      $section.find(".form-row").removeClass("tsg-entry-hidden");
      
   });

   $("#tsg-add-certificate").click(function (e) {
      e.preventDefault();
      $(".tsg-certificate-wrapper").toggleClass("tsg-entry-hidden");
   });

   var certificates = JSON.parse($('#tsg-certificate-input').val() || '[]');
   $('#tsg-user-add-certificate-btn').on('click', function() {
      var certificateText = $('#certificate-input').val().trim();

      if (certificateText === "") {
         $('#tsg-certificate-error-message').show();
         return;
      } else {
         $('#tsg-certificate-error-message').hide();
      }

      certificates.push({ text: certificateText });
  
      certificates.forEach((certificate, index) => {
         certificate.id = index;
      });

      $('#tsg-certificate-input').val(JSON.stringify(certificates));

      const data = {
         action: "tsg_add_save_certificates",
         certificates: JSON.stringify(certificates) 
      };

      renderCertificate(data);
   });

   $(document).on('click', '.delete-certificate-btn', function(e) {  
      e.preventDefault();
      var certificateId = parseInt($(this).data('id'));
     
      certificates = certificates.filter(function(certificate, index) {
         return index !== certificateId;
      });

      certificates.forEach((certificate, index) => {
         certificate.id = index; 
      });

      $('#tsg-certificate-input').val(JSON.stringify(certificates));

      const data = {
         action: "tsg_add_save_certificates",
         certificates: JSON.stringify(certificates) 
      };

      renderCertificate(data);
   });

   function renderCertificate(data) {
      $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
      $('#tsg-adjust-msg-container').html('<div id="tsg-saving-text">Saving<span class="tsg-saving-text-dots"></span></div>');
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: data,
         success: function (response) {
            //  console.log(response);
             $('#tsg-adjust-msg-container').html('<div id="tsg-saving-text">Saved.</div>'); ;
             $('#certificate-input').val('');
             $('#tsg-certificate-container').html(response);
         },
         error: function () {
             $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
             $('#tsg-adjust-msg-container').css('color', 'red').html('An error occurred.');
         },
      });

      setTimeout(function () {
         $('#tsg-adjust-msg-container').fadeOut('slow', function () {
            $(this).html('');
            $(this).addClass('tsg-entry-hidden'); 
         });
      }, 5000);
   }

   //customer -> conpany logo preview
   $("#company_logo_input").on("change", function (event) {
      var imgPreview = $("#company_logo_preview");
      var file = event.target.files[0];

      if (file) {
         var reader = new FileReader();
         reader.onload = function (e) {
            imgPreview.attr("src", e.target.result);
         };
         reader.readAsDataURL(file);
      }
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

   $(".tsg-avatar-upload-btn").on("click", function (e) {
      e.preventDefault();
      $("#tsg-avatar-upload-input").click();
   });

   $(".change-btn").on("click", function (e) {
      e.preventDefault();
      $(this).parents(".edit-parent").find(".editable-input").toggle();
      $(this).parents(".edit-parent").find(".hidable-value").toggle();
   });

   $(".tsg-change-btn").on("click", function (e) {
      e.preventDefault();
      $(this).parents(".tsg-entry-block").find(".editable-input").toggle();
      $(this).parents(".tsg-entry-block").find(".hidable-value").toggle();
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
                     id: item.id,
                     // id: item.slug,
                     text: item.text,
                  };
               }),
            };
         },
         cache: true,
      },
      placeholder: "Select category",
      minimumInputLength: 0, // Start searching after 2 characters
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

      $(".tsg-edit-service-btn").addClass("active");
      $(".tsg-service-edit").show();
      $("#tsg-service-save-btn").show();
      //$(".tsg-service-preview").hide();

      if (productId === "create-new") {
         $(".tsg-edit-service-btn").addClass("locked");
         $(".tsg-delete-service-btn").hide();

         $("#selected-service").val("");
         $("#product-id").val("");
         $("#service-name").val("");
         $("#long-desc").val("");
         $("#short-desc").val("");
         $("#pricing-units").val("");
         $("#pricing-sf").val("");
         $("#pricing-chf").val("");
         $("#taxonomy-select").val("");
         $("#main-image").attr("src", "");

         $(".tsg-service-gallery-image-preview").html("");
         $("#service-gallery-collection").val("");
         $("#performance-analytics").val("");
         $("#performance-analytics").closest(".select").find(".select-name span").text("");

         $("#tsg-selected-service span").text("Create New");
      } else {
         $("#tsg-service-load-buffer").html('<div id="tsg-saving-text">Loading<span class="tsg-saving-text-dots"></span></div>');
         $(".tsg-edit-service-btn").removeClass("locked");
         $(".tsg-delete-service-btn").show();
         $("#selected-service").val(productId);

         let selectedText = $(this).text();
         $("#tsg-selected-service span").text(selectedText);

         // Fetch product details
         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: "POST",
            data: { 
               action: "get_product_details", 
               product_id: productId 
            },
            success: function (response) {
               if (response.success) {
                  var product = response.data;
                  console.log(product);
                  $("#product-id").val(product.id);
                  $("#service-name").val(product.name);
                  $("#long-desc").val(product.long_description);
                  $("#short-desc").val(product.short_description);
                  $("#pricing-units").val(product.regular_price);
                  $("#pricing-sf").val(product.sf_percentage);
                  $("#pricing-chf").val(product.chf_percentage);
                  //$("#taxonomy-select").val(product.categories[0]);
                  $("#performance-analytics").val(product.perf_analytics);
                  $("#performance-analytics").closest(".select").find(".select-name span").text(product.perf_analytics);
                  togglePerformanceAnalytics();

                  $("#main-image").attr("src", product.featured_image);
                  $("#tsg-product-views").html(product.service_views);
                  $("#tsg-product-booking").html(product.bookings);
                  $("#tsg-product-chf-total").html(product.total_chf_value);
                  $("#tsg-product-sf-total").html(product.total_sf_value);

                  var galleryUrls = product.gallery_images.join(",");
                  $("#service-gallery-collection").val(galleryUrls);
                  $("#taxonomy-select").select2('trigger', 'select', {
                     data: { id: product.categories[0].term_id, text: product.categories[0].name }
                  });
                  textInputrenderGallery();
                  $("#tsg-service-load-buffer").html('<div id="tsg-saving-text" style="color: green;">Loaded.</div>');
               }
            },
         });

         setTimeout(function () {
            $('#tsg-service-load-buffer').fadeOut('slow', function () {
               $(this).html('');
            });
         }, 5000);
      }
   });

   // Handle form submission (create/edit product)
   $("#manage-service-form").on("submit", function (e) {
      e.preventDefault();

      $("#tsg-service-save-error").html("");
      let isValid = true;
      const serviceName = $("#service-name").val().trim();
      const shortDescription = $("#short-desc").val().trim();
      const productPrice = $("#pricing-units").val().trim();
      const selectedCategory = $("#taxonomy-select").val(); 

      if (!serviceName) {
         isValid = false;
         $("#tsg-service-save-error").append("<div style='color: red;'>Please enter the service name.</div>");
      }
      if (!shortDescription) {
         isValid = false;
         $("#tsg-service-save-error").append("<div style='color: red;'>Please enter a short description.</div>");
      }
      if (!productPrice || isNaN(productPrice) || parseFloat(productPrice) <= 0) {
         isValid = false;
         $("#tsg-service-save-error").append("<div style='color: red;'>Please enter a valid product price.</div>");
      }
      if (!selectedCategory || selectedCategory.length === 0) {
         isValid = false;
         $("#tsg-service-save-error").append("<div style='color: red;'>Please select at least one category.</div>");
      }

      if (!isValid) {
         return;
      }

      var formData = new FormData(this);
      formData.append("action", "save_product");
      // var formData = $(this).serialize();
      $("#tsg-service-save-error").html('<div id="tsg-saving-text">Saving<span class="tsg-saving-text-dots"></span></div>');

   //    for (let [key, value] of formData.entries()) {
   //       console.log(key, value);
   //   }
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         // data: formData + "&action=save_product",
         data: formData,
         processData: false,
         contentType: false,
         success: function (response) {
            if (response.success) {
               setTimeout(function () {
                  location.reload(); 
               }, 1500);
               $("#tsg-service-save-error").html("<div style='color: green;'>Product saved successfully!</div>");
            } else {
               $("#tsg-service-save-error").html("<div style='color: red;'>Error saving the product. Please try again.</div>");
            }
         },
      });

      setTimeout(function () {
         $('#tsg-service-save-error').fadeOut('slow', function () {
            $(this).html('');
         });
      }, 5000);
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
                     $(".sales-products").html('<div class="error-message"><p>An error occurred while fetching the orders. Please try again later.</p></div>');
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
                                 "<p>Date</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="date"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Referred Member Name</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="ref-by"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Service/Product Purchased</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="product-name"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Transaction Amount (CHF)</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="product-pricing"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Affiliate Fee Earned (CHF)</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="aff_chf"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 '<div class="block-line spb">' +
                                 '<div class="line-left">' +
                                 "<p>Affiliate Fee Earned (SF)</p>" +
                                 "</div>" +
                                 '<div class="line-right">' +
                                 '<p><strong class="aff_sf"></strong></p>' +
                                 "</div>" +
                                 "</div>" +
                                 "</div>"
                           );

                           $orderTemplate.find(".date").text(order.order_date);
                           $orderTemplate.find(".ref-by").text(order.ref);
                           $orderTemplate.find(".product-name").text(order.product_name);
                           $orderTemplate.find(".product-pricing").text(order.main_cost);
                           $orderTemplate.find(".aff_chf").text("CHF " + parseFloat(order.chf_cost));
                           $orderTemplate.find(".aff_sf").text("SF " + parseFloat(order.sf_cost));

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

   //For SF value control (service offering page)
   function validateFields() {
      let sfValue = parseInt($("#pricing-sf").val());
      let chfValue = parseInt($("#pricing-chf").val());
      let error = "";

      if (sfValue < 25 || sfValue > 99) {
         error = "SF value must be between 25 and 99.";
      } else if (chfValue < 1 || chfValue > 75) {
         error = "CHF value must be between 1 and 75.";
      } else if (sfValue + chfValue !== 100) {
         error = "SF and CHF values must add up to 100.";
      }

      if (error) {
         $(".error-message").remove();
         $(".tsg-sf-and-chf-wrapper").append(`<div class="error-message" style="color:red;">${error}</div>`);
      } else {
         $(".error-message").remove();
      }
   }

   $("#pricing-sf").on("input", function () {
      let sfValue = parseInt($(this).val());

      if (sfValue >= 25 && sfValue <= 99) {
         $("#pricing-chf").val(100 - sfValue);
      }

      validateFields();
   });

   $("#pricing-chf").on("input", function () {
      let chfValue = parseInt($(this).val());

      if (chfValue >= 1 && chfValue <= 75) {
         $("#pricing-sf").val(100 - chfValue);
      }

      validateFields();
   });

   //Delete product - service offering page
   $("#tsg-delete-service").on("click", function () {
      let productId = $("#product-id").val();

      if (!confirm("Are you sure you want to delete this product?")) {
         return;
      }

      $("#tsg-service-load-buffer").html('<div id="tsg-saving-text">Deleting<span class="tsg-saving-text-dots"></span></div>');

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "delete_product",
            product_id: productId,
         },
         success: function (response) {
            if (response.success) {
               // alert(response.data.message);
               location.reload();
               $("#tsg-service-load-buffer").html('<div id="tsg-saving-text" style="color: green;">Deleted.</div>');
            } else {
               alert(response.data.message);
            }
         },
         error: function () {
            $("#tsg-service-load-buffer").html("<div style='color: red;'>An error occurred while deleting the product.</div>");
         },
      });

      setTimeout(function () {
         $('#tsg-service-load-buffer').fadeOut('slow', function () {
            $(this).html('');
         });
      }, 5000);
   });

   //gallery file input click
   $("#service-image-btn").on("click", function () {
      $("#service-image").click();
   });

   $("#service-gallery-btn").on("click", function () {
      $("#service-gallery").click();
   });

   $("#service-image, #pre-service-image").on("change", function (event) {
      if (event.target.files && event.target.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
            $(".tsg-main-service-image").attr("src", e.target.result);
         };

         reader.readAsDataURL(event.target.files[0]);
      }
   });

   //customer support page controls | admin sf management page control
   $("#tsg-submit-ticket-btn").on("click", function () {
      $("#tsg-submit-ticket-container").toggle();
   });
   $("#tsg-active-tickets-btn").on("click", function () {
      $("#tsg-active-tickets-container").toggle();
   });

   //Date picker
   $("#calendar").datepicker({
      dateFormat: "dd-mm-yy",
      showAnim: "slideDown",
      position: {
         my: "left top",
         at: "left bottom",
      },
   });

   //Date picker
   $("#tsg-all-transactions-date-from").datepicker({
      dateFormat: "dd-mm-yy",
      showAnim: "slideDown",
      position: {
         my: "left top",
         at: "left bottom",
      },
   });

   //Date picker
   $("#tsg-all-transactions-date-to").datepicker({
      dateFormat: "dd-mm-yy",
      showAnim: "slideDown",
      position: {
         my: "left top",
         at: "left bottom",
      },
   });

   //Date picker
   $("#tsg-transaction-history-date-from").datepicker({
      dateFormat: "dd-mm-yy",
      showAnim: "slideDown",
      position: {
         my: "left top",
         at: "left bottom",
      },
   });

   //Date picker
   $("#tsg-transaction-history-date-to").datepicker({
      dateFormat: "dd-mm-yy",
      showAnim: "slideDown",
      position: {
         my: "left top",
         at: "left bottom",
      },
   });


   $(".tsg-item-toggle-btn").on("click", function (e) {
      e.preventDefault();

      var target = $(this).data("target");
      $(target).toggle();
   });

   $("#tsg-configure-subscription-save-btn").on("click", function () {
      let subscriptionPlan = {};

      $("input[name^='subscription']").each(function() {
         const fieldName = $(this).attr("name");
         const productId = fieldName.match(/\d+/)[0];
         const value = $(this).val();

         subscriptionPlan[productId] = value;
      });

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "configure_subscription",
            data: subscriptionPlan,
         },
         success: function (response) {
            console.log("success");
            console.log(response);
         },
         error: function () {
            alert("An error occurred.");
         },
      });
   });

   $("#tsg-adjust-sf-bonus-save-btn").on("click", function () {
      const sfBonus = $("input[name='sf_bonus_allocation']").val();
      const selectedDate = $("input[name='date']").val();

      console.log("sf_bonus_allocation:", sfBonus);
      console.log("date:", selectedDate);

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "adjust_sf_bonus",
            data: {
                sf_bonus_allocation: sfBonus,
                date: selectedDate
            }
         },
         success: function (response) {
            console.log(response);
         },
         error: function () {
            alert("An error occurred.");
         },
      });
   });

   $("#tsg-allocate-sf-to-member-save-btn").on("click", function () {
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "allocate_sf_to_member",
            data: allocatedMember,
         },
         success: function (response) {
            console.log(response);
         },
         error: function () {
            alert("An error occurred.");
         },
      });
   });

   $("#tsg-withdraw-sf-from-member-save-btn").on("click", function () {
      const amount = $("input[name='withdraw-sf-from-member']").val();
      const userId = $("#sf-withdraw-member-id").val();
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "withdraw_sf_from_member",
            data: {
               amount: amount,
               user_id: userId
            }
         },
         success: function (response) {
            // console.log(response);
            if (response.success) {
               console.log("Credit deducted successfully:", response.message);
            } else {
               console.error("Error:", response.data.message);
            }
         },
         error: function () {
            alert("An error occurred.");
         },
      });
   });

   $("#tsg-remove-sf-from-circulation-save-btn").on("click", function () {
      const amount = $("input[name='remove-sf-from-circulation']").val();
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "remove_sf_from_circulation",
            data: {
               amount: amount
            }
         },
         success: function (response) {
            // console.log(response);
            if (response.success) {
               console.log("Points deducted from admin successfully:", response.message);
            } else {
               console.error("Error:", response.data.message);
            }
         },
         error: function () {
            alert("An error occurred.");
         },
      });
   });

   $('#tsg-all-transactions-save-btn').on('click', function(e) { 
      e.preventDefault(); 

      if (allTransactionsValidate()) {
         sendAllTransactionsData();
      }
   });

   function allTransactionsValidate() {
      let isValid = true;
      let errorMsg = "";
   
      $('#tsg-all-transactions-error-msg').empty();
      const currentDate = new Date().toISOString().split('T')[0];
   
      const dateFrom = $('#tsg-all-transactions-date-from').val();
      const dateTo = $('#tsg-all-transactions-date-to').val();
      const transactionType = $('#all-transactions-transaction-type').val();
      const member = $('#all-transactions-member').val();
   
      if (dateFrom === "") {
         errorMsg += "Please select a 'Date From'.<br>";
         isValid = false;
      } else if (dateFrom > currentDate) {
         errorMsg += "'Date From' cannot be in the future.<br>";
         isValid = false;
      }
   
      if (dateTo === "") {
         errorMsg += "Please select a 'Date To'.<br>";
         isValid = false;
      } else if (dateTo > currentDate) {
         errorMsg += "'Date To' cannot be in the future.<br>";
         isValid = false;
      } else if (dateFrom && dateTo < dateFrom) {
         errorMsg += "'Date To' cannot be earlier than 'Date From'.<br>";
         isValid = false;
      }
   
      if (transactionType === "") {
         errorMsg += "Please select a 'Transaction Type'.<br>";
         isValid = false;
      }
   
      if (member === "") {
         errorMsg += "Please enter a 'Member'.<br>";
         isValid = false;
      }
   
      if (!isValid) {
         $('#tsg-all-transactions-error-msg').html(errorMsg);
      }
   
      return isValid;
   }
   
  function sendAllTransactionsData() {
      const data = {
         dateFrom: $('#tsg-all-transactions-date-from').val(),
         dateTo: $('#tsg-all-transactions-date-to').val(),
         transactionType: $('#all-transactions-transaction-type').val(),
         member: $('#all-transactions-member').val(),
      };


      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "display_all_transactions_data",
            data: data,
         },
         success: function (response) {
            console.log(response);
         },
         error: function () {
            alert("An error occurred.");
         },
      });
   }

   //Transaction history display - Synergy manager
   $('#tsg-transaction-history-save').on('click', function(e) { 
      e.preventDefault(); 
      const data = {
         dataSearch: $('#tsg-transaction-search-value').val(),
         dateFrom: $('#tsg-transaction-history-date-from').val(),
         dateTo: $('#tsg-transaction-history-date-to').val(),
         transactionType: $('#tsg-history-transaction-type').val(),
         member: $('#tsg-transaction-history-member').val(),
         filter: 0
      };

      $('#tsg-transaction-history-error-msg').empty();
      const dateFrom = $('#tsg-transaction-history-date-from').val();
      const dateTo = $('#tsg-transaction-history-date-to').val();
      if (transactionsHistoryValidate(dateFrom, dateTo)) {
         sendAllTransactionsHistory(data);
      }
   });

   //Transaction history display - Admin
   $('#tsg-admin-transaction-filter-btn').on('click', function(e) { 
      e.preventDefault(); 
      const data = {
         dateFrom: $('#tsg-admin-transaction-history-date-from').val(),
         dateTo: $('#tsg-admin-transaction-history-date-to').val(),
         transactionType: $('#admin-affiliate-transaction-type').val(),
         member: $('#admin-affiliate-member').val(),
         filter: 1
      };

      $('#tsg-transaction-history-error-msg').empty();
      const dateFrom = $('#tsg-admin-transaction-history-date-from').val();
      const dateTo = $('#tsg-admin-transaction-history-date-to').val();
      if (transactionsHistoryValidate(dateFrom, dateTo)) {
         sendAllTransactionsHistory(data);
      }
   });

   function transactionsHistoryValidate(dateFrom, dateTo) {
      let isValid = true;
      let errorMsg = "";
     
      const currentDate = new Date().toISOString().split('T')[0];
     
      if (dateFrom > currentDate) {
          errorMsg += "'Date From' cannot be in the future.<br>";
          isValid = false;
      }
     
      if (dateTo > currentDate) {
          errorMsg += "'Date To' cannot be in the future.<br>";
          isValid = false;
      }
     
      if (dateTo < dateFrom) {
          errorMsg += "'Date To' cannot be earlier than 'Date From'.<br>";
          isValid = false;
      }
     
      if (!isValid) {
          $('#tsg-transaction-history-error-msg').html(errorMsg);
      }
     
      return isValid;
   }

   //Transaction history display - Customer
   $('#tsg-customer-show-all-transactions').on('click', function(e) { 
      e.preventDefault(); 
      const currentUserId = $(this).data("id");
      const data = {
         member: currentUserId,
         filter: 0
      };

      if( currentUserId ) {
         sendAllTransactionsHistory(data);
      } else {
         console.log("User id is null");
      }

   });
   
   function sendAllTransactionsHistory(data) {
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "display_all_transactions_history",
            data: data,
         },
         success: function (response) {
            //console.log(response);
            $('.tsg-display-transaction-history').html(response);
         },
         error: function () {
            $('.tsg-display-transaction-history').html("An error occurred.");
         },
      });
   }

   //For select 2 fields
   $(".select2-list").select2();

   //For select field custom to select id without a text
   $('#tsg-transaction-history-member-list li').on('click', function(e) {
         e.preventDefault();
         var userId = $(this).data('id');
         $('#tsg-transaction-history-member').val(userId);
   });
   // $('#tsg-history-transaction-type-list li').on('click', function(e) {
   //    e.preventDefault();
   //    var userId = $(this).data('id');
   //    $('#tsg-history-transaction-type').val(userId);
   // });
   $('#tsg-sf-balance-range-list li.tsg-select-option').on('click', function(e) {
      e.preventDefault();
      var range = $(this).data('id');
      $('#tsg-sf-balance-range').val(range);
   });
   $('#tsg-member-status-list li.tsg-select-option').on('click', function(e) {
      e.preventDefault();
      var status = $(this).data('id');
      $('#tsg-member-status').val(status);
   });
   $('#tsg-member-member-list li').on('click', function(e) {
      e.preventDefault();
      var status = $(this).data('id');
      $('#tsg-member-member').val(status);
   });
   $('#tsg-sf-adjust-member-list li').on('click', function(e) {
      e.preventDefault();
      var status = $(this).data('id');
      $('#tsg-sf-adjust-member').val(status);
   });
   
 
   $("#tsg-members-filter-btn").on("click", function () {
      const data = {
          action: "filter_members", 
          sfRange: $('#tsg-sf-balance-range').val(),
          userStatus: $('#tsg-member-status').val(),
      };
  
      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: "POST",
          data: data,
          success: function (response) {
              console.log(response);
              $('#tsg-members-filter-container-label').removeClass('tsg-entry-hidden');
              $('#tsg-members-filter-container').html(response);
          },
          error: function () {
              alert("An error occurred.");
          },
      });
   });

   $("#tsg-member-member-filter-btn").on("click", function () {
      const data = {
          action: "filter_member_transactions", 
          member: $('#tsg-member-member').val(),
      };
  
      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: "POST",
          data: data,
          success: function (response) {
              console.log(response);
              $('#tsg-member-details-container').html(response);
          },
          error: function () {
              alert("An error occurred.");
          },
      });
   });
  
   $('#tsg-adjust-affiliate-earning-container').hide();
   $('#tsg-adjust-sf-container').hide();
   $('#tsg-adjust-sf-btn').on("click", function () {
      $('#tsg-adjust-sf-container').toggle();
      $('#tsg-adjust-affiliate-earning-container').hide();
   });
   $('#tsg-adjust-affiliate-earning-btn').on("click", function () {
      $('#tsg-adjust-affiliate-earning-container').toggle();
      $('#tsg-adjust-sf-container').hide();
   });
  

   $("#tsg-adjust-sf-save").on("click", function () {
      const data = {
         action: "adjust_sf_amount",
         member: $('#tsg-sf-adjust-member').val(), 
         newSf: $('#tsg-adjust-sf').val()
     };
     
     if (!data.member) {
         $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
         $('#tsg-adjust-msg-container').css('color', 'red').html('Error: Please select a member.');
     } else {

         $.ajax({
             url: tsg_public_ajax.ajax_url,
             type: "POST",
             data: data,
             success: function (response) {
                 console.log(response);
                 $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
                 $('#tsg-adjust-msg-container').css('color', '').html(response); 
             },
             error: function () {
                 $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
                 $('#tsg-adjust-msg-container').css('color', 'red').html('An error occurred.');
             },
         });
     }     
   });

   $("#tsg-adjust-affiliate-earning-save").on("click", function () {

      const data = {
         action: "adjust_affiliate_earning", 
         member: $('#tsg-sf-adjust-member').val(),
         newAffiliateEarning: $('#tsg-adjust-affiliate-earning').val()
     };
     
     if (!data.member) {
         $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
         $('#tsg-adjust-msg-container').css('color', 'red').html('Error: Please select a member.');
     } else {
     
         $.ajax({
             url: tsg_public_ajax.ajax_url,
             type: "POST",
             data: data,
             success: function (response) {
                 console.log(response);
                 $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
                 $('#tsg-adjust-msg-container').css('color', '').html(response); 
             },
             error: function () {
                 $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
                 $('#tsg-adjust-msg-container').css('color', 'red').html('An error occurred.');
             },
         });
     }
     
   });

   
   $("#affiliate-profiles").on("change", function() {
      const data = {
         action: "load_affiliate_profiles", 
         selectedProfile: $(this).val(),
         flipStatus: 0
      };

      loadAffiliateProfiles(data);

   }); 

   $("#tsg-affiliate-profiles-status-change").on("click", function() {
      if (!$("#affiliate-profiles").val()) {
         $('#tsg-affiliate-profiles-error-message').text("Please select a member before submitting.").show();
      } else {
         $('#tsg-affiliate-profiles-error-message').text("").hide();
         const data = {
            action: "load_affiliate_profiles", 
            selectedProfile: $("#affiliate-profiles").val(),
            flipStatus: 1
         };
         loadAffiliateProfiles(data);
      }
   });

   function loadAffiliateProfiles(data) {
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: data,
         success: function (response) {
             console.log(response);
             $('#tsg-affiliate-profiles-container').html(response);
         },
         error: function () {
            alert("An error occurred.");
         },
     });
   }

   $('#tsg-adjust-fee-commission').on('click', function(e) {
      e.preventDefault();
      var commissionRate = parseFloat($('#tsg-commission-rate-input').val());
      var commissionReason = $('#tsg-commission-reason').val();

      if (isNaN(commissionRate) || commissionRate < 0 || commissionRate > 100) {
         $('#tsg-commission-rate-error').text("Please enter a value between 0 and 100.").show();
      } else if (commissionReason === "") {
         $('#tsg-commission-rate-error').text("Please enter a reason.").show();
      } else {
         $('#tsg-commission-rate-error').text("").hide();

         const data = {
            action: "save_affiliate_commission_rate", 
            commission_rate: commissionRate,
            commission_reason: commissionReason
         };

         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
               $('#tsg-commission-rate-display').html(response);
               $('#tsg-commission-reason').val('');
               $('#tsg-commission-rate-input').val('');
               $('#tsg-commisson-rate-toggle').click();      
            },
            error: function() {
               alert('An error occurred while saving the commission rate.');
            }
         });
      }
   });

   $('#tsg-affiliate-audit-btn').on('click', function(e) {
      e.preventDefault();

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: 'POST',
         data: {
            action: 'display_affiliate_commission_adjustment_history',
         },
         success: function(response) {
            $('#tsg-affiliate-audit-container').html(response);
         },
         error: function() {
            $('#tsg-affiliate-audit-container').html('An error occurred while saving the commission rate.');
         }
      });
   });

  
   $('#tsg_view_payment_history').on('click', function(e) {
      e.preventDefault();

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: 'POST',
         data: {
            action: 'display_affiliate_payout_details',
         },
         success: function(response) {
            $('#tsg_affiliate_payout_history').html(response);
         },
         error: function() {
            $('#tsg_affiliate_payout_history').html('An error occurred while saving the commission rate.');
         }
      });
   });

   $("#tsg-save-payment-method").on('click', function(e) {
      e.preventDefault();
      payMethod = $("tsg-admin-setup-payment-method").val();

      if ( payMethod === "") {
         $("#tsg-payment-method-save-error").html('Please select a payment method.');
      } else {
         const data = {
            action: "save_admin_payment_method", 
            payment_method: payMethod,
         };

         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
               $('#tsg-admin-setup-payment-method-display').html(response);
            },
            error: function() {
               $("#tsg-payment-method-save-error").html('An error occurred.');
            }
         });
      }
   });

   $('.approve-button').on('click', function(event) {
      event.preventDefault();

      
      let postId = $(this).data('post-id');
      console.log('Approve Button Clicked. Post ID:', postId);

      if (!postId) {
          alert("Post ID is undefined. Please check the HTML structure.");
          return;
      }

      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'update_withdrawal_status',
              post_id: postId,
              status: 'Approved'
          },
          success: function(response) {
              if (response.success) {
                  alert('Withdrawal approved.');
                  location.reload();
              } else {
                  alert('Failed to update status: ' + response.data);
              }
          }
      });
  });

  $('.reject-button').on('click', function() {
      event.preventDefault();
      let postId = $(this).data('post-id');
      console.log('Approve Button Clicked. Post ID:', postId);

      if (!postId) {
         alert("Post ID is undefined. Please check the HTML structure.");
         return;
      }

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: 'POST',
         data: {
               action: 'update_withdrawal_status',
               post_id: postId,
               status: 'Cancelled'
         },
         success: function(response) {
               if (response.success) {
                  alert('Withdrawal rejected.');
                  location.reload();
               } else {
                  alert('Failed to update status: ' + response.data);
               }
         }
      });
   });
 
   // $('.select-list li').on('click', function() {
   //    const selectedStatus = $(this).text();
   //    $('#status').val(selectedStatus); // Update hidden status input with selected value
   //    $('.select-name span').text(selectedStatus); // Display selected status in the dropdown
   // });

   $('.select-list li').on('click', function() {
      const selectedStatus = $(this).text();
      const dropdownContainer = $(this).closest('.select'); // Find the closest dropdown container

      dropdownContainer.find('input[type="hidden"]').val(selectedStatus); // Update the hidden input within the specific dropdown
      dropdownContainer.find('.select-name span').text(selectedStatus); // Display selected status only within the specific dropdown
  });

   $('#tsg-admin-withdrawals-filter-btn').on('click', function(event) {
      event.preventDefault();

      // Collect filter values
      const dateFrom = $('#date-from').val();
      const dateTo = $('#date-to').val();
      const members = $('#withdrawals-member').val();
      const status = $('#status').val();

      // Send AJAX request with filter data
      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'filter_withdrawal_history',
              date_from: dateFrom,
              date_to: dateTo,
              members: members,
              status: status
          },
          success: function(response) {
              if (response.success) {
                  $('.messages-sub-block').html(response.data.html);
              } else {
                  alert('Failed to fetch data: ' + response.data);
              }
          }
      });
   });

   $('.available-payment-methods li').on('click', function() {
      const selectedValue = $(this).text();
      const dropdownContainer = $(this).closest('.select');
      
      dropdownContainer.find('input[type="hidden"]').val(selectedValue);
      dropdownContainer.find('.select-name span').text(selectedValue);
      // console.log("Selected Payment Method:", selectedValue);
   });

   $('.payment-processing-details li').on('click', function() {
      const selectedValue = $(this).text();
      const dropdownContainer = $(this).closest('.select');

      dropdownContainer.find('input[type="hidden"]').val(selectedValue); 
      dropdownContainer.find('.select-name span').text(selectedValue);
      // console.log("Selected Payment Details:", selectedValue);
   });

   $('#configure-save-payment-securitysettings').on('click', function(event) {
      event.preventDefault();

      const paymentMethod = $('#payment-methods').val();
      const paymentDetails = $('#payment-details').val();

      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'save_payment_settings',
              payment_method: paymentMethod,
              payment_details: paymentDetails
          },
          success: function(response) {
              console.log("AJAX Response:", response);
              if (response.success) {
                  alert('Payment settings saved successfully!');
              } else {
                  alert('Failed to save payment settings: ' + response.data);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error("AJAX Error:", textStatus, errorThrown);
          }
      });
   });


   $('.select-list li').on('click', function() {
      const selectedFee = $(this).text();
      const hiddenInput = $(this).closest('.select-list').prev('input[type="hidden"]');
      hiddenInput.val(selectedFee);
      // console.log("Selected Fee for", hiddenInput.attr('id'), ":", selectedFee);
   });

  $('#tsg-admin-fee-structure-save-btn').on('click', function(event) {
      event.preventDefault();

      const dataToSave = [];

      $('input[type="hidden"][id^="fee-setting-plan"]').each(function() {
          const selectedFee = $(this).val();
          const productID = $(this).data('product-id');

          if (selectedFee) {
              dataToSave.push({ product_id: productID, fee_structure: selectedFee });
          }
      });

      console.log("Data to save:", dataToSave);

      if (dataToSave.length === 0) {
          alert("Please select a fee structure for at least one plan before saving.");
          return;
      }

      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'save_fee_structure',
              fees: dataToSave
          },
          success: function(response) {
              console.log("AJAX Response:", response);
              if (response.success) {
                  alert('Fee structures saved successfully!');
              } else {
                  alert('Failed to save fee structures: ' + response.data);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error("AJAX Error:", textStatus, errorThrown);
          }
      });
   });    

   $('.sf-starting-out li, .sf-increase-reach li, .sf-maximize-impact li').on('click', function() {
      const selectedMultiplier = $(this).text();
      const hiddenInput = $(this).closest('.select-list').prev('input[type="hidden"]');
      
      hiddenInput.val(selectedMultiplier); // Update hidden input with selected value
      console.log("Selected Multiplier for", hiddenInput.attr('id'), ":", selectedMultiplier); // Debug log
  });

  $('#tsg-admin-sf-benefits-save-btn').on('click', function(event) {
   event.preventDefault();

   const dataToSave = [];

   // Loop through each hidden input with a selected multiplier value
   $('input[type="hidden"][id^="sf-multiplier-plan"]').each(function() {
       const selectedMultiplier = $(this).val();
       const productID = $(this).data('product-id');

       if (selectedMultiplier) { // Only add if a multiplier was selected
           dataToSave.push({ product_id: productID, sf_multiplier: selectedMultiplier });
       }
   });

   console.log("Data to save:", dataToSave); // Debug log

   if (dataToSave.length === 0) {
       alert("Please select an SF multiplier for at least one plan before saving.");
       return;
   }

   // Send AJAX request to save all selected values
   $.ajax({
       url: tsg_public_ajax.ajax_url,
       type: 'POST',
       data: {
           action: 'save_sf_multiplier',
           multipliers: dataToSave
       },
       success: function(response) {
           console.log("AJAX Response:", response);
           if (response.success) {
               alert('SF multipliers saved successfully!');
           } else {
               alert('Failed to save SF multipliers: ' + response.data);
           }
       },
       error: function(jqXHR, textStatus, errorThrown) {
           console.error("AJAX Error:", textStatus, errorThrown);
       }
      });
   });

   // $('.select-npl-starting-out li, .select-npl-increase-reach li, .select-npl-maximize-impact li').on('click', function() {
   //    const selectedProductCount = $(this).text();
   //    const hiddenInput = $(this).closest('.select-list').prev('input[type="hidden"]');
      
   //    hiddenInput.val(selectedProductCount); // Update hidden input with selected value
   //    console.log("Selected Product Count for", hiddenInput.attr('id'), ":", selectedProductCount); // Debug log
   // });
   // $('#tsg-admin-product-listed-save-btn').on('click', function(event) {
   //      event.preventDefault();

   //      const dataToSave = [];

   //      // Loop through each hidden input with a selected product count
   //      $('input[type="hidden"][id^="number-products-plan"]').each(function() {
   //          const selectedProductCount = $(this).val();
   //          const productID = $(this).data('product-id'); // Assuming there's a product ID if needed

   //          if (selectedProductCount) { // Only add if a product count was selected
   //              dataToSave.push({ product_id: productID, number_of_products: selectedProductCount });
   //          }
   //      });

   //      console.log("Data to save:", dataToSave); // Debug log

   //      if (dataToSave.length === 0) {
   //          alert("Please select a product count for at least one plan before saving.");
   //          return;
   //      }

   //      // Send AJAX request to save all selected values
   //      $.ajax({
   //          url: tsg_public_ajax.ajax_url,
   //          type: 'POST',
   //          data: {
   //              action: 'save_number_of_products',
   //              product_counts: dataToSave
   //          },
   //          success: function(response) {
   //              console.log("AJAX Response:", response);
   //              if (response.success) {
   //                  alert('Product counts saved successfully!');
   //              } else {
   //                  alert('Failed to save product counts: ' + response.data);
   //              }
   //          },
   //          error: function(jqXHR, textStatus, errorThrown) {
   //              console.error("AJAX Error:", textStatus, errorThrown);
   //          }
   //      });
   // });


   $('.select-npl-starting-out li, .select-npl-increase-reach li, .select-npl-maximize-impact li').on('click', function() {
      const selectedProductCount = $(this).text();
      const hiddenInput = $(this).closest('.select-list').prev('input[type="hidden"]'); // Find the related hidden input

      hiddenInput.val(selectedProductCount); // Update hidden input with selected value
      console.log("Selected Product Count for", hiddenInput.attr('id'), ":", selectedProductCount); // Debug log
   });

   $('#tsg-admin-product-listed-save-btn').on('click', function(event) {
      event.preventDefault();

      const dataToSave = [];

      // Loop through each hidden input with a selected product count
      $('input[type="hidden"][id^="number-products-plan"]').each(function() {
          const selectedProductCount = $(this).val();
          const productID = $(this).data('product-id'); // Ensure the product ID is retrieved

          if (selectedProductCount && productID) { // Only add if both product count and product ID are present
              dataToSave.push({ product_id: productID, number_of_products: selectedProductCount });
          }
      });

      console.log("Data to save:", dataToSave); // Debug log

      if (dataToSave.length === 0) {
          alert("Please select a product count for at least one plan before saving.");
          return;
      }

      // Send AJAX request to save all selected values
      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'save_number_of_products',
              product_counts: dataToSave
          },
          success: function(response) {
              console.log("AJAX Response:", response);
              if (response.success) {
                  alert('Product counts saved successfully!');
              } else {
                  alert('Failed to save product counts: ' + response.data);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error("AJAX Error:", textStatus, errorThrown);
          }
      });
   });


   $('.fee-collection-limit li, .withdrawal-limit li, .exceeding-thresholds-notification li').on('click', function() {
      const selectedValue = $(this).text();
      const hiddenInput = $(this).closest('.select-list').prev('input[type="hidden"]');

      hiddenInput.val(selectedValue); // Update hidden input with selected value
      console.log("Selected Value for", hiddenInput.attr('id'), ":", selectedValue); // Debug log
  });

  $('#threshold-and-limit-save-button').on('click', function(event) {
   event.preventDefault();

   // Gather the selected values from hidden inputs
   const feeCollectionLimit = $('#fee-collection-limit').val();
   const withdrawalLimit = $('#withdrawal-limit').val();
   const notificationSetting = $('#notification').val();

   // Send AJAX request to save values as user meta
   $.ajax({
       url: tsg_public_ajax.ajax_url,
       type: 'POST',
       data: {
           action: 'save_user_limits_and_notification',
           fee_collection_limit: feeCollectionLimit,
           withdrawal_limit: withdrawalLimit,
           notification: notificationSetting
       },
       success: function(response) {
           console.log("AJAX Response:", response);
           if (response.success) {
               alert('Settings saved successfully!');
           } else {
               alert('Failed to save settings: ' + response.data);
           }
       },
       error: function(jqXHR, textStatus, errorThrown) {
           console.error("AJAX Error:", textStatus, errorThrown);
       }
   });
   });

   $("#admin-fee-overview-member").on("select2:select", function(){
      const data = {
         action: "admin_fee_overview_add_services", 
         member: $(this).val(),
      }
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: 'POST',
         data: data,
         success: function(response) {
            console.log(response);
            $("#tsg-admin-fee-overview-service-type").html(response);
         },
         error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
      });
   });

   $("#tsg-fee-overview-filter-btn").on("click", function(e) {
      e.preventDefault();
  
      const member = $("#admin-fee-overview-member").val();
      const date_from = $("#tsg-admin-fee-overview-date-from").val();
      const date_to = $("#tsg-admin-fee-overview-date-to").val();
      const service_type = $("#tsg-admin-fee-overview-service-type").val();
      const transaction_type = $("#tsg-admin-fee-overview-transaction-type").val();
      const affiliate_fees = $("#tsg-admin-fee-overview-affiliate-fees").val();
  
      if (!member || member.trim().length === 0) {
          $("#tsg-admin-fee-overview-error").show().html("Please, select a member").css("color", "red");
          return; 
      } else {
          $("#tsg-admin-fee-overview-error").hide(); 
      }
  
      const data = {
          action: "admin_filter_fee_overview",
          member: member,
          date_from: date_from,
          date_to: date_to,
          service_type: service_type,
          transaction_type: transaction_type,
          affiliate_fees: affiliate_fees,
      };
  
      $.ajax({
          url: tsg_public_ajax.ajax_url,
          type: 'POST',
          data: data,
          success: function(response) {
              $(".tsg-fee-overview-sf").html(response); 
          },
          error: function(jqXHR, textStatus, error) {
              $("#tsg-admin-fee-overview-error").show().html("An error occurred: " + error).css("color", "red");
          }
      });
   });
   
   $("#tsg-admin-reverse-transaction-btn").on("click", function(){
      const [ref_id, ref] = $("#tsg-admin-reverse-transaction").val().split("|");
      const reason = $("#tsg-admin-reverse-transaction-reason").val();
      const data = {
         action: "admin_reverse_transaction", 
         ref_id: ref_id,
         ref: ref,
         reason: reason,
      }

      if ( !reason || reason.trim() === "" ) {
         $("#tsg-admin-reverse-transaction-msg").show();
         $("#tsg-admin-reverse-transaction-msg").html("Please, add a reason.").css("color", "red");
      } else {
         $("#tsg-admin-reverse-transaction-msg").hide();
         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
               // console.log(response);
               $("#tsg-admin-reverse-transaction-msg").show();
               $("#tsg-admin-reverse-transaction-msg").html(response + 'updated!');
            },
            error: function(xhr, status, error) {
               console.error("AJAX error:", error);
         }
         });
      }
   });
   
   $("#tsg-admin-manual-fee-btn").on("click", function(){
      const member = $("#admin-manual-fee-member").val();
      const manualFee = $("#tsg-admin-manual-fee").val();
      const data = {
         action: "admin_manual_fee_adjustment", 
         rmember: member,
         manual_fee: manualFee,
      }

      if (!member || member.trim() === "") {
         $("#tsg-admin-manual-fee-msg").show();
         $("#tsg-admin-manual-fee-msg").html("Please, select a member.").css("color", "red");
      } else if (!manualFee || manualFee.trim() === "") {
         $("#tsg-admin-manual-fee-msg").show();
         $("#tsg-admin-manual-fee-msg").html("Please, add a fee amount.").css("color", "red");
      } else {
         $("#tsg-admin-manual-fee-msg").hide();
         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
               // console.log(response);
               $("#tsg-admin-manual-fee-msg").show();
               $("#tsg-admin-manual-fee-msg").html(response + 'updated!');
            },
            error: function(xhr, status, error) {
               console.error("AJAX error:", error);
         }
         });
      }
   });

   //Profile data upload
   $('.tsg-save-profile').on('click', function (e) {
      e.preventDefault();

      var $saveButton = $(this);
      var $wrapper = $(this).closest('.tsg-entry-block-wrapper');
      var $parent = $(this).closest('.tsg-entry-block');
      var $input = $parent.find('.tsg-input-field');
      var $section = $(this).closest('.tsg-entry-block-section');
      
      var fieldName = $input.attr('name');
      var fieldValue = $input.val();
      // console.log(fieldName);
      $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Saving<span class="tsg-saving-text-dots"></span></div>');

      $.ajax({
          url: tsg_public_ajax.ajax_url, 
          type: 'POST',
          data: {
              action: 'onchange_update_user_profile', 
              field_name: fieldName,
              field_value: fieldValue,
          },
          success: function (response) {
            console.log(response);
            $saveButton.addClass("tsg-entry-hidden");
            $section.removeClass("active");
            $parent.find(".edit-pencil").removeClass("tsg-entry-hidden");
            $parent.find(".form-curr-value").removeClass("tsg-entry-hidden");
            $parent.find(".form-row").addClass("tsg-entry-hidden");
            $parent.find('.form-curr-value').text(response);
            $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Saved.</div>');
          },
          error: function () {
              $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Failed to save changes. Please try again.</div>');
          },
      });

      setTimeout(function () {
         $wrapper.find('.tsg-error-msg').fadeOut('slow', function () {
             $(this).html('');
             $(this).show(); 
         });
     }, 5000);

   });

   //Profile description update
   $('.tsg-save-description').on('click', function (e) {
      e.preventDefault();

      var $saveButton = $(this);
      var $wrapper = $(this).closest('.tsg-entry-block-wrapper');
      var $section = $(this).closest('.tsg-entry-block-section');
      var $parent = $(this).closest('.tsg-entry-block');
      var $input = $section.find('.tsg-input-field');
      
      
      var fieldName = $input.attr('name');
      var fieldValue = $input.val();
      // console.log(fieldName);
      $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Saving<span class="tsg-saving-text-dots"></span></div>');

      $.ajax({
          url: tsg_public_ajax.ajax_url, 
          type: 'POST',
          data: {
              action: 'onchange_update_user_profile', 
              field_name: fieldName,
              field_value: fieldValue,
          },
          success: function (response) {
            console.log(response);
            $saveButton.addClass("tsg-entry-hidden");
            $parent.find(".bio-edit-pencil").removeClass("tsg-entry-hidden");
            $section.find(".form-curr-value").removeClass("tsg-entry-hidden");
            $section.find(".form-row").addClass("tsg-entry-hidden");
            $section.find('.form-curr-value').text(response);
            $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Saved.</div>');
          },
          error: function () {
              $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Failed to save changes. Please try again.</div>');
          },
      });

      setTimeout(function () {
         $wrapper.find('.tsg-error-msg').fadeOut('slow', function () {
             $(this).html('');
             $(this).show(); 
         });
     }, 5000);

   });

   $('#tsg-copy-referral-url').on('click', function (e) {
      e.preventDefault(); 

      const referralUrl = $(this).data('referral');

      navigator.clipboard.writeText(referralUrl).then(() => {
          alert('Referral URL copied to clipboard!');
      }).catch(err => {
          console.error('Failed to copy text: ', err);
      });
   });
  
   $('#tsg-avatar-upload-input').on('change', function () {
      var $wrapper = $(this).closest('.tsg-entry-block-wrapper');
      var fileData = this.files[0]; 
      var formData = new FormData(); 
      formData.append('action', 'update_profile_image'); 
      formData.append('bp_avatar_upload', fileData); 

      $.ajax({
          url: tsg_public_ajax.ajax_url, 
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          beforeSend: function () {
            $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Saving<span class="tsg-saving-text-dots"></span></div>');
          },
          success: function (response) {
            // console.log(response);
               $('#tsg-profile-img-preview').attr('src', response.data.new_image_url);
               $wrapper.find('.tsg-error-msg').html('<div id="tsg-saving-text">Saved.</div>'); 
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText); 
            console.log(status); 
            console.log(error); 
            
            var errorMsg = 'An error occurred while uploading the image. Please try again.';
            try {
               var responseJson = JSON.parse(xhr.responseText);
               if (responseJson.message) {
                     errorMsg = responseJson.message;
               }
            } catch (e) {
               console.error('Error parsing response:', e);
            }

            $wrapper.find('.tsg-error-msg').html(errorMsg);
         }
        
      });

      setTimeout(function () {
         $wrapper.find('.tsg-error-msg').fadeOut('slow', function () {
            $(this).html('');
            $(this).show(); 
         });
      }, 5000);

   });

   //customer service edit toggle
   $(".tsg-edit-service-btn").on("click", function (e) {
         e.preventDefault();
         const $button = $(this);
         $button.toggleClass("active");

         if ($button.hasClass("active")) {
            $(".tsg-service-edit").show();
            $("#tsg-service-save-btn").show();
            //$(".tsg-service-preview").hide();
         } else {
            $(".tsg-service-edit").hide();
            //$(".tsg-service-preview").show();
            $("#tsg-service-save-btn").hide();
         }
   });

   //customer service edit -> Service performance analytics show hide
   function togglePerformanceAnalytics() {
      const value = $("#performance-analytics").val(); 
      if (value === "Enabled") {
          $(".tsg-service-performance-analytics").show(); 
      } else if (value === "Disabled") {
          $(".tsg-service-performance-analytics").hide(); 
      }
   }


   //customer service edit -> Handle file selection and preview
   let galleryFiles = [];
   function initializeGalleryFiles(fromTxtDelete = true) {

      const inputFiles = $("#service-gallery")[0].files;
      
      for (let i = 0; i < inputFiles.length; i++) {

         if(fromTxtDelete) {
            galleryFiles.push(inputFiles[i]);
         }

         const reader = new FileReader();
         reader.onload = function (e) {
               const wrapper = $(`
                  <div class="tsg-service-gallery-image-wrapper item w3">
                     <div class="tsg-uploaded-picture-wrapper itemr">
                           <img class="uploaded-picture opt tsg-service-gallery-image" src="${e.target.result}" />
                     </div>
                     <button class="delete-image-btn" data-index="${i}">&times;</button>
                  </div>
               `);

               $(".tsg-service-gallery-image-preview").append(wrapper);
         };

         reader.readAsDataURL(inputFiles[i]);
      }

      tsgUpdateFileInput(); 
   }

   // Update the file input value with the current files in galleryFiles
   function tsgUpdateFileInput() {
      const dataTransfer = new DataTransfer();

      galleryFiles.forEach(file => {
         dataTransfer.items.add(file);
      });

      $("#service-gallery")[0].files = dataTransfer.files;
   }

   //File input -> Handle new file selection
   $("#service-gallery").on("change", function (event) {
      const files = event.target.files;

      for (let i = 0; i < files.length; i++) {
         const file = files[i];
         const reader = new FileReader();

         reader.onload = function (e) {
               const wrapper = $(`
                  <div class="tsg-service-gallery-image-wrapper item w3">
                     <div class="tsg-uploaded-picture-wrapper itemr">
                           <img class="uploaded-picture opt tsg-service-gallery-image" src="${e.target.result}" />
                     </div>
                     <button class="delete-image-btn" data-index="${galleryFiles.length}">&times;</button>
                  </div>
               `);

               $(".tsg-service-gallery-image-preview").append(wrapper);

               galleryFiles.push(file);
               tsgUpdateFileInput();
         };

         reader.readAsDataURL(file);
      }

      setTimeout(() => {
            $("#service-gallery").val("");
      }, 0); // Clear the input to allow re-selecting the same files
   });

   //File input -> Handle delete image
   $(document).on("click", ".delete-image-btn", function () {
      const index = $(this).data("index");
      galleryFiles.splice(index, 1);

      $(this).closest(".tsg-service-gallery-image-wrapper").remove();
      tsgUpdateFileInput();
   });

   //File input -> Initialize the gallery files on page load
   // $(document).ready(function () {
   //    initializeGalleryFiles();
   // });


   //Text input -> Function to render the gallery based on text input value
   function textInputrenderGallery() {
      const galleryInput = $("#service-gallery-collection");
      const galleryFiles = galleryInput.val() ? galleryInput.val().split(",") : [];
      const previewContainer = $(".tsg-service-gallery-image-preview");
      previewContainer.empty(); 

      galleryFiles.forEach((file, index) => {
          const wrapper = $(`
              <div class="tsg-service-gallery-image-wrapper item w3">
                  <div class="tsg-uploaded-picture-wrapper itemr">
                      <img class="uploaded-picture opt tsg-service-gallery-image" src="${file}" />
                  </div>
                  <button class="txt-delete-image-btn" data-index="${index}">&times;</button>
              </div>
          `);
          previewContainer.append(wrapper);
      });
   }

   $(document).on("click", ".txt-delete-image-btn", function () {
      const index = $(this).data("index"); 
      const galleryInput = $("#service-gallery-collection");
      let galleryFiles = galleryInput.val() ? galleryInput.val().split(",") : [];

      galleryFiles.splice(index, 1);

      galleryInput.val(galleryFiles.join(","));
      textInputrenderGallery();
      initializeGalleryFiles(false);
   });



   // change the user password
   let isEdited = false;

   $('#client-password').on('focus', function () {
      if (!isEdited && $(this).val() === '********') {
          $(this).val(''); // Clear the dummy value
          isEdited = true; // Ensure this runs only once
      }
   });

   $('.user-settings-password-save').on('click', function (e) {
      e.preventDefault();

      let password = $('#client-password').val();

      if (!password || password === '********') {
         alert('Please enter a new password.');
         return;
      }

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: 'POST',
         data: {
            action: 'change_user_password',
            password: password,
         },
         success: function (response) {
            if (response.success) {
                  alert('Password changed successfully!');
                  $('#client-password').val('********'); // Reset to dummy value
                  isEdited = false; // Allow re-editing
            } else {
                  alert(response.data || 'Error updating password.');
            }
         },
         error: function () {
            alert('An unexpected error occurred.');
         }
      });
   });

   $("#tsg-show-trading-history").on("click", function(e){
      e.preventDefault();
      const userId = $(this).data("id");

      $('#tsg-show-trading-history-container').show();
      $('#tsg-show-trading-history-container').html('<div id="tsg-saving-text">Loading<span class="tsg-saving-text-dots"></span></div>');

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: 'POST',
         data: {
            action: 'get_current_user_buy_sell_history',
            user_id: userId,
         },
         success: function (response) {
            $('#tsg-show-trading-history-container').html(response);
         },
         error: function (error) {
            $('#tsg-show-trading-history-container').html(error);
         }
      });

   });
});




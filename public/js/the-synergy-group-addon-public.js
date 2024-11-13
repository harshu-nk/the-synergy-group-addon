jQuery(document).ready(function ($) {
   $(".edit-pencil:not(.bio-edit-pencil)").click(function (e) {
      e.preventDefault();
      $(this).toggleClass("active");
      const parentRow = $(this).closest(".line-row");

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

      // var certificateId = 'certificate-' + (certificates.length + 1);
      // certificates.push({ id: certificateId, text: certificateText });

      certificates.push({ text: certificateText });
      var certificateIndex = certificates.length - 1;
      var certificateId = 'certificate-' + certificateIndex;
      certificates[certificateIndex].id = certificateId;

      $('#tsg-certificate-input').val(JSON.stringify(certificates));

      const data = {
         action: "tsg_add_save_certificates",
         certificates: JSON.stringify(certificates) 
      };

      renderCertificate(data);
   });

   $(document).on('click', '.delete-certificate-btn', function(e) {  
      e.preventDefault();
      var certificateId = $(this).data('id');
      var certificateText = $(this).data('text');

      // Find the certificate text in the array and remove it
      // certificates = certificates.filter(function(certificate) {
      //    return certificate.text !== certificateText;
      // });
      certificates = certificates.filter(function(certificate) {
         return certificate.id !== certificateId && certificate.text !== certificateText;
      });

      $('#tsg-certificate-input').val(JSON.stringify(certificates));
      $('#' + certificateId).remove();

      const data = {
         action: "tsg_add_save_certificates",
         certificates: JSON.stringify(certificates) 
      };

      renderCertificate(data);
   });

   function renderCertificate(data) {
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: data,
         success: function (response) {
             console.log(response);
             $('#certificate-input').val('');
             $('#tsg-certificate-container').html(response);
         },
         error: function () {
             $('#tsg-adjust-msg-container').removeClass('tsg-entry-hidden');
             $('#tsg-adjust-msg-container').css('color', 'red').html('An error occurred.');
         },
      });
   }


   // $('#tsg-certificate-container').on('click', '.delete-certificate-btn', function(e) {
   //    e.preventDefault();
   //    var certificateId = $(this).data('id');
   //    var certificateText = $(this).data('text');

   //    $('#' + certificateId).remove();

   //    // Find the certificate text in the array and remove it
   //    certificates = certificates.filter(function(text) {
   //       return text !== certificateText;
   //    });

   //    console.log(certificates);
   // });

   // Certificates Array
   // var certificates = [];

   // Add Certificate Button Click
   // $("#tsg-user-add-certificate-btn").on("click", function () {
   //    var certificateText = $("#certificate-input").val().trim();

   //    if (certificateText === "") {
   //       $("#tsg-certificate-error-message").show();
   //       return;
   //    } else {
   //       $("#tsg-certificate-error-message").hide();
   //    }

   //    certificates.push(certificateText);

   //    // AJAX to Save Certificates
   //    saveCertificates();
   // });

   // Render Certificate
   // function renderCertificate(certificateText, id) {
   //    var certificateId = "certificate-" + id;
   //    var newCertificate = `
   //       <div class="item w2" id="${certificateId}">
   //             <div class="itemr">
   //                <div class="award-block tc">
   //                   <a href="#" class="block-edit delete-certificate-btn" data-id="${certificateId}" data-text="${certificateText}">
   //                         <img src="https://thesynergygroup.ch/wp-content/plugins/the-synergy-group-addon/public/img/account/edit.svg" alt="edit icon">
   //                   </a>
   //                   <div class="award-icon">
   //                         <img src="https://thesynergygroup.ch/wp-content/plugins/the-synergy-group-addon/public/img/account/award.svg" alt="award icon">
   //                   </div>
   //                   <p class="fs-20 mt18 tsg-certificate-name">${certificateText}</p>
   //                </div>
   //             </div>
   //       </div>
   //    `;
   //    $("#tsg-certificate-container").append(newCertificate);
   // }

   // Delete Certificate Button Click
   // $("#tsg-certificate-container").on("click", ".delete-certificate-btn", function (e) {
   //    e.preventDefault();
   //    var certificateId = $(this).data("id");
   //    var certificateText = $(this).data("text");

   //    $("#" + certificateId).remove();
   //    certificates = certificates.filter((text) => text !== certificateText);

   //    // Save Updated Certificates Array
   //    saveCertificates();
   // });

   // Save Certificates to Database via AJAX
   // function saveCertificates() {
   //    $.ajax({
   //       url: tsg_public_ajax.ajax_url,
   //       type: "POST",
   //       data: {
   //          action: "save_certificates",
   //          certificates: certificates,
   //       },
   //       success: function (response) {
   //          console.log(response);
   //          renderCertificate(certificateText, certificates.length);
   //          $("#certificate-input").val("");
   //          $(".tsg-certificate-wrapper").addClass("tsg-entry-hidden");
   //          //console.log("Certificates saved successfully:", response);
   //       },
   //       error: function (error) {
   //          console.error("Error saving certificates:", error);
   //       },
   //    });
   // }

   // Fetch Certificates on Page Load

   // $.ajax({
   //       url: tsg_public_ajax.ajax_url,
   //       type: "POST",
   //       data: {
   //          action: "fetch_certificates"
   //       },
   //       success: function(response) {
   //          if (response.success) {
   //             certificates = response.data.certificates || [];
   //             certificates.forEach((cert, index) => renderCertificate(cert, index + 1));
   //          } else {
   //             console.error("Error fetching certificates:", response);
   //          }
   //       },
   //       error: function(error) {
   //          console.error("AJAX error fetching certificates:", error);
   //       }
   // });

   //user profile pic show
   $("#tsg-avatar-upload-input").on("change", function (event) {
      var imgPreview = $("#tsg-profile-img-preview");
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

      if (productId === "create-new") {
         $(".tsg-delete-service-btn").hide();

         $("#selected-service").val("");
         $("#product-id").val("");
         $("#service-name").val("");
         $("#long-desc").val("");
         $("#short-desc").val("");
         // $("#product-price").val("");
         $("#pricing-units").val("");
         $("#pricing-sf").val("");
         $("#pricing-chf").val("");
         $("#taxonomy-select").val("");
         $("#activity-type").val("");
         $("#service-image").val("");

         $("#tsg-selected-service span").text("Create New");
      } else {
         $(".tsg-delete-service-btn").show();
         $("#selected-service").val(productId);

         let selectedText = $(this).text();
         $("#tsg-selected-service span").text(selectedText);

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
                  // $("#service-image").val(product.main_image);
                  $("#service-image").attr("src", product.main_image);
                  // $('#activity-type').val(product.gallery); // Load gallery images (implement your logic here)
               }
            },
         });
      }
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

      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "delete_product",
            product_id: productId,
         },
         success: function (response) {
            if (response.success) {
               alert(response.data.message);
               location.reload();
            } else {
               alert(response.data.message);
            }
         },
         error: function () {
            alert("An error occurred while deleting the product.");
         },
      });
   });

   //gallery file input click
   $("#service-image-btn").on("click", function () {
      $("#service-image").click();
   });

   $("#service-gallery-btn").on("click", function () {
      $("#service-gallery").click();
   });

   $("#service-image").on("change", function (event) {
      if (event.target.files && event.target.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
            $("#main-image").attr("src", e.target.result);
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

   //Date picker
   $("#tsg-admin-schedule-date").datepicker({
      dateFormat: "dd-mm-yy",
      showAnim: "slideDown", 
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
  
   
   function sendAllTransactionsHistory(data) {
      $.ajax({
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         data: {
            action: "display_all_transactions_history",
            data: data,
         },
         success: function (response) {
            // console.log(response);
            $(".tsg-admin-cash-flow-title").show();
            $('.tsg-display-transaction-history').html(response);
         },
         error: function () {
            $(".tsg-admin-cash-flow-title").show();
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
            $(".tsg-admin-payout-history-title").show();
            $('#tsg_affiliate_payout_history').html(response);
         },
         error: function() {
            $(".tsg-admin-payout-history-title").show();
            $('#tsg_affiliate_payout_history').html('An error occurred while saving the commission rate.');
         }
      });
   });

   ('#tsg_save_payment_method').on('click', function(e) {
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
               $("#tsg-payment-method-save-error").html('Payment method saved successfully.');
            },
            error: function() {
               $("#tsg-payment-method-save-error").html('An error occurred.').css('color', 'red');;
            }
         });
      }
   });

   ('#tsg_admin_save_schedule').on('click', function(e) {
      e.preventDefault();
      scheduleDate = $("tsg-admin-schedule-date").val();

      if ( scheduleDate === "") {
         $("#tsg-payment-method-save-error").html('Please select a schedule date.');
      } else {
         const data = {
            action: "save_admin_schedule_date", 
            schedule_date: scheduleDate,
         };

         $.ajax({
            url: tsg_public_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
               $('#tsg-admin-schedule-display').html(response);
               $("#tsg-payment-method-save-error").html('Payment schedule date saved successfully.');
            },
            error: function() {
               $("#tsg-payment-method-save-error").html('An error occurred.').css('color', 'red');
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
 
});

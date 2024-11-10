jQuery(document).ready(function ($) {
   console.log('select2 function initialized');
   $("#select-members").select2({
      ajax: {
         url: tsg_public_ajax.ajax_url,
         type: "POST",
         dataType: "json",
         delay: 250,
         data: function (params) {
            return {
               action: "search_users", 
               search: params.term, 
            };
         },
         processResults: function (data) {
            console.log("AJAX request successful:", data);
            return {
               results: data.map(item => ({
                  id: item.id,  // Replace with the correct property name
                  text: item.text // Replace with the correct property name
               })),
            };
         },
         cache: true,
      },
      placeholder: "Select members",
      minimumInputLength: 1, 
      multiple: true, 
   });
   

   $("#communications-form").validate();
   $("#communications-form").submit(function (event) {
      event.preventDefault();

      let selectedUsers = $("#select-members").select2("data");
      selectedIds = [];
      selectedUsers.forEach(function (val, i) {
         selectedIds.push(val.id);
      });
      var formData = {
         members: selectedIds,
         notificationType: $("input[name='notification-type']").val(),
         greeting: $("textarea[name='greeting']").val(),
         subject: $("textarea[name='subject']").val(),
         body: $("textarea[name='body']").val(),
         attachment: $("input[name='attachment']").val(),
         action: "admin_send_notification",
      };

      $.ajax({
         type: "POST",
         url: tsg_ajax.ajax_url,
         data: formData,
         success: function (data) {
            console.log(data);
         },
         error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         },
      });
   });
});

jQuery(document).ready(function ($) {
   $("#select-members").select2({
      ajax: {
         url: tsg_ajax.ajax_url,
         type: "POST",
         dataType: "json",
         delay: 250,
         data: function (params) {
            return {
               action: "search_users", // The action we will hook into
               search: params.term, // The search query
            };
         },
         processResults: function (data) {
            return {
               results: data, // Parse the results into the format expected by Select2
            };
         },
         cache: true,
      },
      placeholder: "Select members",
      minimumInputLength: 2, // Start searching after 2 characters
      multiple: true, // Allow multiple selections
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

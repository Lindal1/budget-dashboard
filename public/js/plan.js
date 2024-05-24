(function ($) {
    $(document).ready(function () {
        $('.edit-icon').on('click', function () {
            var planUuid = $(this).data('plan-uuid');
            var categoryUuid = $(this).data('category-uuid');
            var month = $(this).data('month');
            var year = $(this).data('year');
            var value = $(this).siblings('.value').text();

            $('#editModal').data('plan-uuid', planUuid);
            $('#editModal').data('category-uuid', categoryUuid);
            $('#editModal').data('month', month);
            $('#editModal').data('year', year);
            $('#editModal #value').val(value);

            $('#editModal').modal('show');
        });

        $('#saveChanges').on('click', function () {
            var planUuid = $('#editModal').data('plan-uuid');
            var categoryUuid = $('#editModal').data('category-uuid');
            var month = $('#editModal').data('month');
            var year = $('#editModal').data('year');
            var value = $('#value').val();

            $.ajax({
                url: '/plan/' + planUuid + '/' + categoryUuid + '/' + month + '/' + year + '/value/' + value,
                type: 'POST',
                success: function (data) {
                    // Обработка успешного ответа
                    $('#editModal').modal('hide');

                    var valueElement = $('i[data-plan-uuid="' + planUuid + '"][data-category-uuid="' + categoryUuid + '"][data-month="' + month + '"][data-year="' + year + '"]').siblings('.value');
                    valueElement.text(value);
                },
                error: function () {
                    alert('Error');
                }
            });
        });
    });
})(jQuery);
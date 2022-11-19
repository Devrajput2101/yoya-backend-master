<script>
// get state 
$(document).on('change', 'select#country_id', function (e) {
    e.preventDefault();
    var CountryID = $(this).val();
    getstatelist(CountryID);
});

function getstatelist(CountryID) {
    $.ajax({
        url:  "<?= base_url("admin/states/getState") ?>",
        type: 'POST',
        data: {CountryID: CountryID},
        dataType: 'json',
        beforeSend: function (){
            $('select#state_id').find("option:eq(0)").html("Please wait....");
        },
        success: function (json){
            var options = '';
            options +='<option value="">Select State</option>';
            for (var i = 0; i < json.length; i++) {
                options += '<option value="' + json[i].state_id + '">' + json[i].state_name + '</option>';
            }
            $("select#state_id").html(options);
 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
</script>

<script>
// get city
$(document).on('change', 'select#state_id', function (e) {
    e.preventDefault();
    var StateID = $(this).val();
    getcitylist(StateID);
});

function getcitylist(StateID) {
    $.ajax({
        url:  "<?= base_url("admin/citys/getCity") ?>",
        type: 'POST',
        data: {StateID: StateID},
        dataType: 'json',
        beforeSend: function (){
            $('select#city_id').find("option:eq(0)").html("Please wait....");
        },
        success: function (json){
            var options = '';
            options +='<option value="">Select City</option>';
            for (var i = 0; i < json.length; i++) {
                options += '<option value="' + json[i].city_id + '">' + json[i].city_name + '</option>';
            }
            $("select#city_id").html(options);
 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
</script>
<?php
if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
    $banner_img=base_url("uploads/banner/".$get_banner->image);
} else{
    $banner_img=base_url("assets/images/resource/mslider1.jpg");
} ?>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>List of Freelancers</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block no-padding List_Of_Workers Employees_Search_List">
        <div class="container">
            <div class="row no-gape">
                <aside class="col-lg-3 column border-right Employees_Search_Panel">
                    <div class="Employees_Search_Panel_Data">
                        <form method="post" id="filter_form">
                            <div class="widget">
                                <div class="search_widget_job">
                                    <div class="field_w_search">
                                        <input type="text" id="title_keyword" name="title_keyword" placeholder="Search Keywords"  onkeydown="filter_job();"  value="" />
                                        <i class="la la-search"></i>
                                    </div>
                                    <div class="field_w_search">
                                        <input type="text" name="search_location" id="location" placeholder="All Locations" onchange="filter_job();" value="" autocomplete="off"/>
                                        <i class="la la-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="widget">
                                <h3 class="sb-title open">Specialization</h3>
                                <div class="specialism_widget">
                                    <div class="dropdown-field">
                                        <select id="example" class="example" multiple>
                                            <?php if(!empty($get_category)){
                                            foreach ($get_category as $key) {?>
                                            <option value="<?= $key->id?>"><?= $key->category_name?></option>
                                            <?php  } } ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </aside>
                <div class="col-lg-9 column Employees_Search_Result">
                    <div class="padding-left">
                        <div class="emply-resume-sec">
                            <div id="worker_list"></div>
                            <div align="center" id="pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
<script>
$(document).ready(function () {
    filter_data(1);
    //alert('hii'); return false;
    function filter_data(page) {
        var base_url = $("#base_url").val();
        var displayProduct = 5;
        $('#worker_list').html(createSkeleton(displayProduct));

        function createSkeleton(limit) {
            var skeletonHTML = '';
            for (var i = 0; i < limit; i++) {
                skeletonHTML += '<div class="ph-item">';
                skeletonHTML += '<div class="ph-col-4">';
                skeletonHTML += '<div class="ph-picture"></div>';
                skeletonHTML += '</div>';
                skeletonHTML += '<div>';
                skeletonHTML += '<div class="ph-row">';
                skeletonHTML += '<div class="ph-col-12 big"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '</div>';
                skeletonHTML += '</div>';
                skeletonHTML += '</div>';
            }
            return skeletonHTML;
        }

        var action = 'fetch_data';
        $.ajax({
            url: base_url + "home/workerlist_fetchdata/" + page,
            method: "POST",
            dataType: "JSON",
            data: {
                action: action
            },
            success: function (data) {
                $('#worker_list').html(data.product_list);
                $('#pagination_link').html(data.pagination_link);
            }
        })
    }

    $(document).on('click', '.pagination li a', function (event) {
        event.preventDefault();
        var page = $(this).data('ci-pagination-page');
        filter_data(page);
    });
});
</script>

<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="dashboard-job-container">
                <center><h5>MANAGE LOGO<span id="current-tab"></span></h5></center>
                <hr>
                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#slider-form-tab" role="tab">Slider Form</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#slider-list-tab" role="tab">List</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="slider-form-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">

                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <form id="logo-form" action="" method="">
                                                 <div class="form-group">
                                                    <label> <small>Title/Description </small></label>
                                                    <input type="text" class="form-control" name="ads_title" tabindex="1" placeholder="" required>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="email" class="control-label "><small>Duration</small></label>
                                                        <select name="duration" class="form-control" required tabindex="2">
                                                            <option value="7">1 week</option>
                                                            <option value="14">2 weeks</option>
                                                            <option value="21">3 weeks</option>
                                                            <option value="30">1 month</option>
                                                            <option value="60">2 months</option>
                                                            <option value="90">3 months</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label> <small>Link </small></label>
                                                    <input type="url" class="form-control" name="ads_link" tabindex="3" placeholder="http://yourdomain.com" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                        <label for="email" class="control-label required"><small>Upload Image</small></label> 
                                                            <input type="file" id="input_file" name="userfile" data-buttonText="Choose Image" class="filestyle"  data-buttonName="btn-secondary" data-input="true" accept="image/*" style="" tabindex="6">
                                                            <small class="text-muted">(Image dimensions 150 x 150)</small> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="ads-preview-box">
                                                        <img id="ads-preview" src="" alt="" class="img-responsive" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-success btn-materialize" id="btn-save-ad" name="submit" tabindex="13">
                                                        Save Ads
                                                    </button>
                                                </div>
                                            </form>
                                        </div>  
                                    </div>  

                                </div>
                            </div>
                        </div>
                    </div>

            

                    <div class="tab-pane animated fadeIn" id="slider-list-tab" role="tabpanel">
                        <div class="tab3-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                   

                                </div>
                                <div class="box-body">

                                    <table class="table table-responsive no-border-top" id="logo-list-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort" style="width: 5%;"> 
                                                <small class="header">Id</small>
                                                </th>
                                                <th style="width: 15%;"><small class="header">Title</small></th>
                                                <th style="width: 15%;"><small class="header">Start Date</small></th>
                                                <th style="width: 10%;"><small class="header">End Date</small></th>
                                                <th style="width: 15%;"><small class="header">Duration</small></th>
                                                <th style="width: 10%;"><small class="header">Status</small></th>
                                                <th class="no-sort" style="width:15%; text-align: center;"></th>   
                                            </tr>    
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>    
<?php $this->load->view('template/modal')?>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/logo.js');?>"></script>
<div class="app-drawer-wrapper" id="search_drawer">
    <div class="drawer-nav-btn">
        <button type="button" class="hamburger hamburger--elastic is-active">
            <span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
    </div>
    <div class="drawer-content-wrapper">
        <div class="scrollbar-container">
            <h3 class="drawer-heading">Advanced Filter Options</h3>
            <div class="drawer-section">
                
                <div class="row">

                    <div class="card-body">

                        <?=form_open('', array('id'=>'advanced_filter_form', 'name'=>'advanced_filter_form'))?>


                            <?php if(isset($filter_options['customer_id'])){?>
                            <div class="form-group">
                                <label class="" for="">Customer</label>
                                <select class="form-control" id="search_customer_id" name="search_customer_id" style="width: 100%;">
                                </select>
                            </div>
                            <?php } ?>


                            <?php if(isset($filter_options['relationship_manager_id'])){?>
                            <div class="form-group">
                                <label class="" for="">Relationship Manager</label>
                                <select class="form-control" id="search_relationship_manager_id" name="search_relationship_manager_id" style="width: 100%;">
                                </select>
                            </div>
                            <?php } ?>


                            <?php if(isset($filter_options['product_id'])){?>
                            <div class="form-group">
                                <label class="" for="">Product</label>
                                <select class="form-control" id="search_product_id" name="search_product_id">
                                    <option value="">Please select a product</option>
                                    <?php 
                                        if(isset($products) && count($products)>0){
                                            foreach($products as $_product){
                                    ?>
                                    <option value="<?=$_product['id']?>"><?=$_product['product_description']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>


                            
                            <div class="form-row form-group">
                                
                                <div class="col-6">
                                    <label class="" for="">From</label>
                                    <input class="form-control date-picker-input-alt" type="text" name="search_createdat_from" id="search_createdat_from" placeholder="Select a date from">
                                </div>
                                <div class="col-6">
                                    <label class="" for="">To</label>
                                    <input class="form-control date-picker-input-alt" type="text" name="search_createdat_to" id="search_createdat_to" placeholder="Select a date to">
                                </div>

                            </div><!-- /.form-group -->

                            <?php if(isset($filter_options['maturity_date'])){?>
                            <div class="form-row form-group">
                                
                                <div class="col-6">
                                    <label class="" for="">Maturity From</label>
                                    <input class="form-control date-picker-input-alt" type="text" name="search_maturity_date_from" id="search_maturity_date_from" placeholder="Select a date from">
                                </div>
                                <div class="col-6">
                                    <label class="" for="">Maturity To</label>
                                    <input class="form-control date-picker-input-alt" type="text" name="search_maturity_date_to" id="search_maturity_date_to" placeholder="Select a date to">
                                </div>

                            </div><!-- /.form-group -->
                            <?php } ?>

                            <?php if(isset($filter_options['maturity_date'])){?>
                            <div class="form-row form-group">
                                
                                <div class="col-6">
                                    <label class="" for="">Withdrawal From</label>
                                    <input class="form-control date-picker-input-alt" type="text" name="search_withdrawal_date_from" id="search_withdrawal_date_from" placeholder="Select a date from">
                                </div>
                                <div class="col-6">
                                    <label class="" for="">Withdrawal To</label>
                                    <input class="form-control date-picker-input-alt" type="text" name="search_withdrawal_date_to" id="search_withdrawal_date_to" placeholder="Select a date to">
                                </div>

                            </div><!-- /.form-group -->
                            <?php } ?>


                            <?php if(isset($filter_options['region_id'])){?>
                            <div class="form-group">
                                <label class="" for="">Region</label>
                                <select class="form-control" id="search_region_id" name="search_region_id">
                                    <option value="">Select to filter by region</option>
                                    <?php 
                                        if(isset($regions) && count($regions)>0){
                                            foreach($regions as $_d){
                                    ?>
                                    <option value="<?=$_d['region_name']?>"><?=$_d['region_name']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>


                            <?php if(isset($filter_options['state_id'])){?>
                            <div class="form-group">
                                <label class="" for="">State</label>
                                <select class="form-control" id="search_state_id" name="search_state_id">
                                    <option value="">Select to filter by state</option>
                                    <?php 
                                        if(isset($states) && count($states)>0){
                                            foreach($states as $_d){
                                    ?>
                                    <option value="<?=$_d['id']?>"><?=$_d['state_name']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>


                            <?php if(isset($filter_options['branch_id'])){?>
                            <div class="form-group">
                                <label class="" for="">Branch</label>
                                <select class="form-control" id="search_branch_id" name="search_branch_id">
                                    <option value="">Select to filter by branch</option>
                                    <?php 
                                        if(isset($branches) && count($branches)>0){
                                            foreach($branches as $_d){
                                    ?>
                                    <option value="<?=$_d['id']?>"><?=$_d['branch_description']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>


                            <?php if(isset($filter_options['marital_status'])){?>
                            <div class="form-group">
                                <label class="" for="">Marital Status</label>
                                <select class="form-control" id="search_marital_status" name="search_marital_status">
                                    <option value="">Select to filter by status</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Married">Married</option>
                                    <option value="Single">Single</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>

                            <?php if(isset($filter_options['gender'])){?>
                            <div class="form-group">
                                <label class="" for="">Gender</label>
                                <select class="form-control" id="search_gender" name="search_gender">
                                    <option value="">Select to filter by gender</option>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>


                            <?php if(isset($filter_options['customer_status'])){?>
                            <div class="form-group">
                                <label class="" for="">Customer Status</label>
                                <select class="form-control" id="search_customer_status" name="search_customer_status">
                                    <option value="">Select to filter by customer status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Deactivated</option>
                                    <option value="pending">Pending Approval</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>


                            <?php if(isset($filter_options['loan_payment_status'])){?>
                            <div class="form-group">
                                <label class="" for="">Loan Payment Status</label>
                                <select class="form-control" id="search_loan_payment_status" name="search_loan_payment_status">
                                    <option value="">Select to filter by status</option>
                                    <option value="active">Approved</option>
                                    <option value="pending">Pending Approval</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>

                            <?php if(isset($filter_options['loan_schedule_status'])){?>
                            <div class="form-group">
                                <label class="" for="">Loan Payment Status</label>
                                <select class="form-control" id="search_loan_schedule_status" name="search_loan_schedule_status">
                                    <option value="">Select to filter by status</option>
                                    <option value="pending">All Unpaid</option>
                                    <option value="overdue">Overdue</option>
                                    <option value="approved">Paid</option>
                                    <option value="paid_partial">Paid Partial</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>

                            <?php if(isset($filter_options['transaction_status'])){?>
                            <div class="form-group">
                                <label class="" for="">Transaction Status</label>
                                <select class="form-control" id="search_transaction_status" name="search_transaction_status">
                                    <option value="">Select to filter by status</option>
                                    <option value="active">Approved</option>
                                    <option value="pending">Pending Approval</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>
                
                            <?php if(isset($filter_options['investment_status'])){?>
                            <div class="form-group">
                                <label class="" for="">Investment Status</label>
                                <select class="form-control" id="search_investment_status" name="search_investment_status">
                                    <option value="">Select to filter by status</option>
                                    <option value="active">Approved/Active</option>
                                    <option value="prematured">Premature Withdrawn</option>
                                    <option value="matured">Matured</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>

                            <?php if(isset($filter_options['payment_mode'])){?>
                            <div class="form-group">
                                <label class="" for="">Payment Mode</label>
                                <select class="form-control" id="search_payment_mode" name="search_payment_mode">
                                    <option value="">Select to filter by payment mode</option>
                                    <option value="Bank Deposit">Bank Deposit</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div><!-- /.form-group -->
                            <?php } ?>

                            

                            <div class="divider"></div>

                            <div class="form-row form-group">
                                
                                <div class="col-6">
                                    <button type="button" class="mb-2 mr-2 btn btn-secondary btn-lg btn-block" onclick="resetFilters()">Reset</button>
                                    <!--<input type="reset" class="mb-2 mr-2 btn btn-secondary btn-lg btn-block" value="Reset">-->
                                </div>
                                <div class="col-6">
                                    <button type="button" class="mb-2 mr-2 btn btn-primary btn-lg btn-block" onclick="init()">Filter</button>
                                </div>

                            </div><!-- /.form-group -->

                        <?=form_close()?>

                    </div><!-- /.card-body -->

                </div><!-- /.row -->


            </div>

            
        </div>
    </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
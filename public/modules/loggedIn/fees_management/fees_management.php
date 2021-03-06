<?php
require_once('../../../../scripts/template_scripts.php');
$omsObj = new omsHelperScript();
?>
<div>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a ui-sref="app.dashboard">Dashboard</a></li>
        <li class="active">Fees management</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Fees management</h1>
    <!-- end page-header -->

    <div class="row hiddenItem" id="filters">
        <div class="panel panel-inverse" data-sortable-id="ui-general-1">
            <div class="panel-heading">
                <button type="button" class="close" aria-hidden="true" ng-click="vm.toggleFilters()">×</button>
                <h4 class="panel-title">Filter</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fName">Name</label>
                            <input type="text" id="fName" class="form-control" ng-model="vm.filter.name" placeholder="Fee name" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fAvailabilityFrom">Availability from</label>
                            <input type="text" id="fAvailabilityFrom" class="form-control" ng-model="vm.filter.availability_from" placeholder="Availability from" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fAvailabilityTo">Availability to</label>
                            <input type="text" id="fAvailabilityTo" class="form-control" ng-model="vm.filter.availability_to" placeholder="Availability to" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="availability_unit">Availability unit</label>
                            <select id="availability_unit" class="form-control" ng-model="vm.filter.availability_unit" ng-options="availabilityUnit.id as availabilityUnit.name for availabilityUnit in vm.availability_units" placeholder="Fee availability unit" >
                                <option value="">Any</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fPriceFrom">Price from</label>
                            <input type="text" id="fPriceFrom" class="form-control" ng-model="vm.filter.price_from" placeholder="Price from" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fPriceTo">Price to</label>
                            <input type="text" id="fPriceTo" class="form-control" ng-model="vm.filter.price_to" placeholder="Price to" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fCurrency">Currency</label>
                            <input type="text" id="fCurrency" class="form-control" ng-model="vm.filter.currency" placeholder="Currency" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mandatory">Mandatory</label>
                            <select id="mandatory" class="form-control" ng-model="vm.filter.mandatory" placeholder="Mandatory" >
                                <option value="">Any</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success" ng-click="vm.searchFeeGrid()"><i class="fa fa-search"></i> Search</button>
                        <button class="btn btn-danger" ng-click="vm.clearSearch()"><i class="fa fa-ban"></i> Clear search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php
            if($omsObj->hasWriteAccess('fees_management')) { ?>
                <button class="btn btn-primary" data-target="#feeModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Fee</button>
            <?php } ?>
        </div>
        <div class="col-md-8 text-right">
            <button class="btn btn-success" ng-click="vm.toggleFilters()"><i class="fa fa-search"></i> Toggle filters</button>
            <button class="btn btn-warning" ng-click="vm.exportGrid()"><i class="fa fa-file-excel-o"></i> Export to XLS</button>
        </div>
    </div>
    <div class="row">
        &nbsp;
    </div>
	<div class="row">
		<div class="col-md-12">
			<table id="feesGrid"></table>
			<div id="feesPager"></div>
		</div>
	</div>
</div>

<?php
if($omsObj->hasWriteAccess('fees_management')) { ?>
    <!-- #modal-dialog -->
    <div class="modal fade" id="feeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Fee add/edit</h4>
                </div>
                <form name="feeForm" method="POST" class="margin-bottom-0" novalidate>
                    <div class="modal-body">
                        <div class="alert alert-warning" ng-show="vm.fee.id != null">
                            Editing will only affect newer payments and not old ones!
                        </div>
                        <div class="form-group m-b-20">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" ng-model="vm.fee.name" placeholder="Fee name" required/>
                        </div>
                        <div class="form-group m-b-20">
                            <label for="availability">Availability</label>
                            <input type="number" id="availability" class="form-control" ng-model="vm.fee.availability" placeholder="Fee availability" required/>
                        </div>
                        <div class="form-group m-b-20">
                            <label for="availability_unit">Availability unit</label>
                            <select id="availability_unit" class="form-control" ng-model="vm.fee.availability_unit" ng-options="availabilityUnit.id as availabilityUnit.name for availabilityUnit in vm.availability_units" placeholder="Fee availability unit" required>
                                
                            </select>
                        </div>
                        <div class="form-group m-b-20">
                            <label for="price">Price</label>
                            <input type="text" id="price" class="form-control" ng-model="vm.fee.price" placeholder="Fee price" required/>
                        </div>
                        <div class="form-group m-b-20">
                            <label for="currency">Currency</label>
                            <input type="text" id="currency" class="form-control" ng-model="vm.fee.currency" placeholder="Fee currency" required/>
                        </div>
                        <div class="form-group m-b-20">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" ng-model="vm.fee.is_mandatory"> Mandatory
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-danger" ng-click="vm.closeAndReset()"><i class="fa fa-ban"></i> Close</button>
                        <button ng-disabled="feeForm.$pristine || feeForm.$invalid" class="btn btn-sm btn-success" ng-click="vm.saveFee()"><i class="fa fa-save"></i> Save fee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
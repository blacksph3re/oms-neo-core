<?php
require_once('../../../../scripts/template_scripts.php');
$omsObj = new omsHelperScript();
?>
<div>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a ui-sref="app.dashboard">Dashboard</a></li>
        <li class="active">Users</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Users</h1>
    <!-- end page-header -->

    <div class="row hiddenItem" id="filters">
        <div class="panel panel-inverse" data-sortable-id="ui-general-1">
            <div class="panel-heading">
                <button type="button" class="close" aria-hidden="true" ng-click="vm.toggleFilters()">×</button>
                <h4 class="panel-title">Filter</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fName">Name</label>
                            <input type="text" id="fName" class="form-control" ng-model="vm.filter.name" placeholder="User name" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fDob">Date of birth</label>
                            <input type="text" id="fDob" class="form-control" ng-model="vm.filter.date_of_birth" placeholder="Date of birth" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fContactEmail">Registration email</label>
                            <input type="text" id="fContactEmail" class="form-control" ng-model="vm.filter.contact_email" placeholder="Registration email" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fGender">Gender</label>
                            <select id="fGender" class="form-control" ng-model="vm.filter.gender" ng-options="value.id as value.name for value in vm.genderTypes track by value.id">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fAntenna">Antenna</label>
                            <select class="form-control" id="fAntenna" ng-model="vm.filter.antenna_id" ng-options="antenna.id as antenna.name for antenna in vm.registrationFields.antennae track by antenna.id">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fDepartment">Department</label>
                            <select class="form-control" id="fDepartment" ng-model="vm.filter.department_id" ng-options="department.cell[0] as department.cell[1] for department in vm.departments.rows track by department.cell[0]">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fInternalEmail">Internal email</label>
                            <input type="text" id="fInternalEmail" class="form-control" ng-model="vm.filter.internal_email" placeholder="Internal email" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fStudyType">Study type</label>
                            <select class="form-control" id="fStudyType" ng-model="vm.filter.studies_type_id" ng-options="type.id as type.name for type in vm.registrationFields.study_type track by type.id">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fStudyField">Study field</label>
                            <select class="form-control" id="fStudyField" ng-model="vm.filter.studies_field_id" ng-options="field.id as field.name for field in vm.registrationFields.study_field track by field.id">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fStatus">Status</label>
                            <select class="form-control" id="fStatus" ng-model="vm.filter.status" ng-options="status.id as status.name for status in vm.statuses track by status.id">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success" ng-click="vm.searchUserGrid()"><i class="fa fa-search"></i> Search</button>
                        <button class="btn btn-danger" ng-click="vm.clearSearch()"><i class="fa fa-ban"></i> Clear search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php
            if($omsObj->hasWriteAccess('users')) { ?>
                <button class="btn btn-primary" data-target="#userModal" data-toggle="modal"><i class="fa fa-plus"></i> Add User</button>
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
			<table id="usersGrid"></table>
			<div id="usersPager"></div>
		</div>
	</div>
    <div class="row">
        &nbsp;
    </div>
    <div class="row well m-2">
        <h5>Legend</h5>
        <div class="col-md-4 text-center">
            <div class="p-10" style="background: #5cb85c; color: #000; width: 100%">
                Active
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-10" style="background: #C1BCBC; color: #000; width: 100%">
                Inactive
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-10" style="background: #d9534f; color: #000; width: 100%">
                Suspended
            </div>
        </div>
    </div>
</div>

<?php
if($omsObj->hasWriteAccess('users')) { ?>
    <!-- #modal-dialog -->
    <div class="modal fade" id="userModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">User add/edit</h4>
                </div>
                <form name="userAddForm" method="POST" class="margin-bottom-0" novalidate>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            The users added via this method will be <b>inactive</b>!<br />To activate the user, you need to follow the normal flow!
                        </div>
                        <div class="row">
                            <h3 class="text-center">Personal information</h3>
                            <div class="col-md-6">
                                <div class="form-group m-b-20">
                                    <div class="form-group">
                                        <label for="first_name">First name *</label>
                                        <input id="first_name" type="text" name="firstname" placeholder="First name" class="form-control" ng-model="vm.user.first_name" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-20">
                                    <div class="form-group">
                                        <label for="last_name">Last name *</label>
                                        <input id="last_name" type="text" name="lastname" placeholder="Last name" class="form-control" ng-model="vm.user.last_name" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of birth *</label>
                                    <input id="date_of_birth" type="text" name="date_of_birth" placeholder="date of birth" class="form-control" ng-model="vm.user.date_of_birth" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gender">Gender *</label>
                                    <select id="gender" class="form-control" ng-model="vm.user.gender" ng-options="value.id as value.name for value in vm.genderTypes" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <h3 class="text-center">Contact information</h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email address *</label>
                                    <input id="email" type="email" name="email" placeholder="Email address" class="form-control" ng-model="vm.user.contact_email" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_validated">Email address repeat *</label>
                                    <input id="email_validated" type="email" name="email_validated" placeholder="Email address repeat" class="form-control" ng-model="vm.user.contact_email_confirmation" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input id="phone" type="text" name="phone" placeholder="phone address" class="form-control" ng-model="vm.user.phone" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input id="address" type="text" name="address" placeholder="address" class="form-control" ng-model="vm.user.address" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input id="city" type="text" name="city" placeholder="city" class="form-control" ng-model="vm.user.city" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zipcode">Zip code</label>
                                    <input id="zipcode" type="text" name="zipcode" placeholder="zipcode" class="form-control" ng-model="vm.user.zipcode" />
                                </div>
                            </div>
                            <hr />
                            <h3 class="text-center">Other information</h3>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="antenna">Antenna *</label>
                                    <select class="form-control" id="antenna" ng-model="vm.user.antenna_id" ng-options="antenna.id as antenna.name for antenna in vm.registrationFields.antennae track by antenna.id">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="university">University *</label>
                                    <input id="university" type="text" name="university" placeholder="university" class="form-control" ng-model="vm.user.university" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="studies_type">Study type *</label>
                                    <select class="form-control" id="studies_type" ng-model="vm.user.studies_type" ng-options="type.id as type.name for type in vm.registrationFields.study_type track by type.id">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="study_field">Study field *</label>
                                    <select class="form-control" id="study_field" ng-model="vm.user.study_field" ng-options="field.id as field.name for field in vm.registrationFields.study_field track by field.id">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-danger" ng-click="vm.closeAndReset()"><i class="fa fa-ban"></i> Close</button>
                        <button ng-disabled="userAddForm.$pristine || userAddForm.$invalid" class="btn btn-sm btn-success" ng-click="vm.saveUser()"><i class="fa fa-save"></i> Save user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="activateUserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Activating user {{vm.user.first_name}} {{vm.user.last_name}}</h4>
                </div>
                <form name="activateForm" method="POST" class="margin-bottom-0" novalidate>
                    <div class="modal-body">
                        <h4>Basic details</h4>
                        <div class="form-group m-b-20">
                            <label for="activateDepartment">Department</label>
                            <select class="form-control" id="activateDepartment" ng-model="vm.user.department_id" ng-options="department.cell[0] as department.cell[1] for department in vm.departments.rows track by department.cell[0]">
                                <option></option>
                            </select>
                        </div>
                        <hr />
                        <div class="row">
                            
                            <h4>Roles</h4>
                            <div class="form-group m-b-20" ng-repeat="role in vm.roles">
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" ng-model="vm.user.roles[role.cell[0]]" value="{{role.cell[0]}}"> {{role.cell[1]}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">   
                            <h4>Fees</h4>
                            <div class="alert alert-warning">
                                Fees with no paid no date will be considered being paid today!
                            </div>
                            <div class="form-group m-b-20" ng-repeat="fee in vm.fees">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" ng-model="vm.user.fees[fee.cell[0]]" value="{{fee.cell[0]}}"> {{fee.cell[1]}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" ng-show="vm.user.fees[fee.cell[0]]">
                                        <label>Paid on</label>
                                        <input id="feepaid_{{fee.cell[0]}}" class="form-control paidOnDateFee" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-danger" ng-click="vm.closeAndResetActivate()"><i class="fa fa-ban"></i> Close</button>
                        <button ng-disabled="activateForm.$pristine || activateForm.$invalid" class="btn btn-sm btn-success" ng-click="vm.activateUser()"><i class="fa fa-save"></i> Activate user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
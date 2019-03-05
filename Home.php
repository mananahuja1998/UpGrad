<?php
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Phone Directory</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
<div ng-app = "myApp" class = "container" style="width:550px">
<div style="text-align:center;color:black">
<h3><b>PHONE DIRECTORY</b></h3>
</div>
<div ng-controller = "ContactController">
<div align="right">
<a href="#" ng-click="searchUser()">{{title}}</a>
</div>
<form role = "form" class="well" ng-hide="ifSearchUser">
<div class = "form-group">
<label for = "name"> Name:  </label>
<input type = "text" id = "name" class = "form-control" placeholder = "Enter Name " ng-model = "newcontact.name">
</div>
<div class = "form-group">
<label for = "phone"> Phone:  </label>
<input type = "text" id = "phone" class = "form-control" placeholder = "Enter Phone " ng-model = "newcontact.phone">
</div>
<br>
<input type="hidden" ng-model="newcontact.id">
<input type="button" class="btn btn-primary" ng-click="saveContact()" class="btn btn-primary" value = "Submit">
</form>
<div><h4><b>Registered Users</b></h4>
<table ng-if="contacts.length" class = "table table-striped table-bordered table-hover">
<thead>
<tr class = "info">
<th>Name</th>
<th>Phone</th>
<th ng-if="!ifSearchUser">Action</th>
</tr>
</thead>
<tbody>
<tr ng-repeat = "contact in contacts">
<td>{{ contact.name }}</td>
<td>{{ contact.phone }}</td>
<td ng-if="!ifSearchUser">
<a href="#" ng-click="edit(contact.id)" role = "button" class = "btn btn-info">edit</a> &nbsp;
<a href="#" ng-click="delete(contact.id)" role = "button" class = "btn btn-danger">delete</a>
</td>
</tr>
</tbody>
</table>
<div ng-hide="contacts.length > 0">No Users Found</div>
</div>
<h4>User you are registering :-</h4>
<h5>NAME :- {{ newcontact.name }}</h5>
<h5>PHONE :- {{ newcontact.phone }}</h5>
</div>
</div>
</body>
</html>
<script>
var myApp = angular.module("myApp", []);
myApp.service("ContactService" , function(){
var uid = 1;
var contacts = [{
'id' : 0,
'name' : 'Manan Ahuja',
'phone' : '9582191147'}];	
// Save Service for sving new contact and saving existing edited contact.
this.save = function(contact)  
{
if(contact.id == null)                       
{
contact.id = uid++;
contacts.push(contact);
}
else
{
for(var i in contacts)
{
if(contacts[i].id == contact.id)
{
contacts[i] = contact;
}
}
}
};
// serach for a contact
this.get = function(id)
{
for(var i in contacts )
{
if( contacts[i].id == id)
{
return contacts[i];
}
}
};
//Delete a contact
this.delete = function(id)
{
for(var i in contacts)
{
if(contacts[i].id == id)
{
contacts.splice(i,1);
}
}
};	
//Show all contacts
this.list = function()
{
return contacts;
}	;	
});
////Controller area .....
myApp.controller("ContactController" , function($scope , ContactService){
console.clear();
$scope.ifSearchUser = false;
$scope.title ="List of Users";
$scope.contacts = ContactService.list();
$scope.saveContact = function()
{
console.log($scope.newcontact);
if($scope.newcontact == null || $scope.newcontact == angular.undefined)
return;
ContactService.save($scope.newcontact);
$scope.newcontact = {};
};		
$scope.delete = function(id)
{
ContactService.delete(id);
if($scope.newcontact != angular.undefined && $scope.newcontact.id == id)
{
$scope.newcontact = {};
}
};		
$scope.edit = function(id)
{
$scope.newcontact = angular.copy(ContactService.get(id));
};		
$scope.searchUser = function(){
if($scope.title == "List of Users"){
$scope.ifSearchUser=true;
$scope.title = "Back";
}
else
{
$scope.ifSearchUser = false;
$scope.title = "List of Users";
}		  
};
});
</script>
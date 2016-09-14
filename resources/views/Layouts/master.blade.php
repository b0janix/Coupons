<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Coupons</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<style type="text/css">
input[type="image"]{
height: 15px;
width: 15px;
margin-left: 3px;
}
</style>
</head>
<body>

@yield('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
//secret_one
//I'm deactivating all theese buttons and submit buttons that have the appropriate classes and ids
$(".button").prop("disabled", true);
$("#month").prop("disabled", true);
   var x=0;
$('#edit').attr('disabled',true);
$('#detach').attr('disabled',true);
$('#dismiss').attr('disabled',true);
$('#add').attr('disabled',true);
//This id belongs to the Add more fields button located on the distribution Create view
$("#add_field").click(function(e){
//on the click event the x variable that is defined for 0 will be increased for 1
//here x acts as a counter of the input fields that i'm adding dynamically using jQuery
x++;
//jQuery sets the value of x to the hidden input field with an id of secret
$("#secret").val(x);
/*if there are siebling input fields whose string part of the id is equal to the one of the current ones, 
but the difference of the values of x is 1, make those previous input fields to be read only*/
if(($("#cnumber"+(x-1)).val() && $("#number"+(x-1)).val() && x>1)==true){
$("#cnumber"+(x-1)).prop('readonly', true);
$("#number"+(x-1)).prop('readonly', true);
$("#name"+(x-1)).prop('readonly', true);
}

//I'm appending the following input fields to the div with a form-row class
/*every input field has its own id created by concatinating the given string for the id attribute bellow and the value of x in that moment*/
$(".form-row").append('<input type="number" name="couponNumber[]" id="cnumber' + x + '" class="inputsC horizontal' + x + '"/><input type="number" name="accountNumber[]" id="number' + x + '" class="inputsA horizontal' + x + '"/><input type="text" name="workerName[]" id="name' + x + '" class="inputsW horizontal' + x + '"/><input type="text" name="workersDepartment[]" id="department' + x + '" class="inputsD horizontal' + x + '"/><input type="image" src="http://localhost:8000/images/Xbutton.png" class="horizontal' + x + '"><br class="horizontal' + x + '" id="nl'+ x +'">');

$('input[type="image"]').click(function(e){
//when the input with type image is clicked, decrease the value of x for 1, set that value to the hidden input field secret
//remove all elements with that class, the class of the image element is the string horiozntal plus the value of x
x--;
$("#secret").val(x);
var y;
y=$(this).attr("class");
$("."+y).remove();
e.preventDefault();
});

$("#number"+x).change(function(){
/*when the value of the field with id: number plus x is changed, make a post ajax request 
to the post_credentials_month_meal route*/
$.ajax({
type:"post",
url:"/post_credentials_month_meal",
data:{'couponNumber': $("#cnumber"+x).val(), 'accountNumber': $("#number"+x).val()},
dataType: "text",
success: function(data){
//on success will log the returned data and will set the data value to the input fields that are from type text
console.log(data);
$("#cnumber"+x).val(null);
$("#number"+x).val(null);
$("#name"+x).val(data);
$("#department"+x).val(data);
},
//jQuery XMLHttpRequest object
error: function(jqXHR) {
/*If the coupons can't be found the returnIfDistributionDuplicate method will return inetrnal server error
because i'm trying to access the properties of the coupon and worker objects which in our case are null */
if (jqXHR.status == 500) {
console.log('The coupons are not duplicates, this is not an error :)');}} 
});
});
// I'm using jQuery UI autocomplete widget when entering data into the input fields
/*When you start typing into the input field an ajax call instantly is created to the route specifed bellow 
and an URl query string term is sent*/
//That route leads us to the autocomplete controller and its autocompleteAction method 
var ac_config = {
source: "http://localhost:8000/search",
select: function(event, ui){
$("#number"+x).val(ui.item.value);
$("#name"+x).val(ui.item.label);
$("#department"+x).val(ui.item.department);
},
minLength:1
};
$("#number"+x).autocomplete(ac_config);
//for every input descendand of the element with class .form-row, that is not input from type image, on change event
$(".form-row input:not(:image)").change(function(e){
//define variable as empty array
var arr=[];
$(".form-row input:not(:image)").each(function(){
//if the current element is an empty string, disable the button with class submit 
if($(this).val()==""){
$(".submit").attr("disabled",true);
}
//push the value of the current array into the arr array
arr.push($(this).val());
});
//define new empty array arr1
var arr1=[]
$.each(arr, function(index, element){
//check for each element  whether it is empty string
if(element!=""){
//if it is push the letter a into the array arr1
arr1.push('a');
}
});
if($(arr1).length == $(".form-row input:not(:image)").length){
//if the number of elements of arr1 is equal to the number of elements of our dom selection, enable the button with submit class
$(".submit").attr("disabled",false);
}
console.log(arr1);
});

//when clicking the add more fields button, in case if the previous row of inputs are empty or at least some of them are empty
$("#add_field").click(function(e){
if(($("#cnumber"+(x-1)).val()=="" || $("#number"+(x-1)).val()=="")==true){
//deactivate the add more fields button
$("#add_field").prop("disabled", true);
//remove the previous fields intended for coupon number and account number
$("#cnumber"+(x-1)).remove();
$("#number"+(x-1)).remove();
/*In their place insert input text fields with the specified value bellow, 
when the visitor clicks some of these two fields, they will be removed and the button will be activated again*/
$('<input type="text" value="Required values" class="cn"/><input type="text" value="Required values" class="cn"/>').insertBefore("#name"+(x-1));
if(($(".cn").val()=="Required values" || $("#name"+(x-1))=="")==true)
{
$(".cn").click(function() {
$(".cn").remove();
$("#name"+(x-1)).remove();
$("#nl"+(x-1)).remove();
$("#add_field").prop("disabled", false);
});
}
}
      });

    });
//This id belongs to the Add more fields button located on the Processing.create and Processing.createBD views
$("#process").click(function(e){
//on the click event the x variable that is defined for 0 will be increased for 1
//here x acts as a counter of the input fields that i'm adding dynamically using jQuery
    x++;
//jQuery sets the value of x to the hidden input field with an id of secret
  $("#secret").val(x);
/*if there are siebling input fields whose string part of the id is equal to the one of the current ones, 
but the difference of the values of x is 1, make those previous input fields to be read only*/
  if(($("#pcnumber"+(x-1)).val() && $("#pnumber"+(x-1)).val() && x>1)==true){
$("#pcnumber"+(x-1)).prop('readonly', true);
$("#pnumber"+(x-1)).prop('readonly', true);
$("#pname"+(x-1)).prop('readonly', true);
}
//I'm appending the following input fields to the div with a form-row class
/*every input field has its own id created by concatinating the given string for the id attribute bellow and the value of x in that moment*/
$(".form-row").append('<input type="number" name="couponNumber[]" id="pcnumber' + x + '" class="inputsC horizontal' + x + '"/><input type="number" name="accountNumber[]" id="pnumber' + x + '" class="inputsA horizontal' + x + '"/><input type="text" name="workerName[]" id="pname' + x + '" class="inputsW horizontal' + x + '"/><input type="text" name="workersDepartment[]" id="pdepartment' + x + '" class="inputsD horizontal' + x + '"/><input type="image" src="http://localhost:8000/images/Xbutton.png" class="horizontal' + x + '"><br class="horizontal' + x + '" id="pnl'+ x +'">');

//when the input with type image is clicked, decrease the value of x for 1, set that value to the hidden input field secret
//remove all elements with that class, the class of the image element is the string horiozntal plus the value of x
$('input[type="image"]').click(function(e){
x--;
$("#secret").val(x);
var y;
y=$(this).attr("class");
$("."+y).remove();
e.preventDefault();
});
/*when the value of the field with id: pcnumber plus x is changed, make a post ajax request 
to the post_title*/
$("#pcnumber"+x).change(function(){
$.ajax({
type:"post",
url:"/post_title",
data:{'date': $("#datepicker").val(),'meal' : $("#meal").val(), 'accountNumber': $("#pnumber"+x).val(), 
'workerName': $("#pname"+x).val()},
dataType: "text",
success: function(data){
//on success will log the returned data and will set the data value to the input fields that are from type text
console.log(data);
$("#pcnumber"+x).val(null);
$("#pnumber"+x).val(null);
$("#pname"+x).val(data);
$("#pdepartment"+x).val(data);
     },
//jQuery XMLHttpRequest object
error: function(jqXHR) {
/*If the coupons can't be found the returnIfProcessingDuplicate method will return inetrnal server error
because i'm trying to access the properties of the coupon and worker objects which in our case are null */
if (jqXHR.status == 500) {
console.log('The coupons are not duplicates, this is not an error :)');}}
});
});

// I'm using jQuery UI autocomplete widget when entering data into the input fields
/*When you start typing into the input field an ajax call instantly is created to the route specifed bellow 
and an URl query string term is sent*/
//That route leads us to the autocomplete controller and its autocompleteCouponAction method 
var object = {
source: "http://localhost:8000/coupon_search",
select: function(event, ui){
$("#pcnumber"+x).val(ui.item.value);
$("#pnumber"+x).val(ui.item.account);
$("#pname"+x).val(ui.item.label);
$("#pdepartment"+x).val(ui.item.department);

},
minLength:1
};

$("#pcnumber"+x).autocomplete(object);
//for every input descendand of the element with class .form-row, that is not input from type image, on change event
$(".form-row input:not(:image)").change(function(e){
//define variable as empty array
var arr=[];
$(".form-row input:not(:image)").each(function(){
//if the current element is an empty string, disable the button with class submit 
if($(this).val()==""){
$(".submit").attr("disabled",true);
}
//push the value of the current array into the arr array
arr.push($(this).val());
});
//define new empty array arr1
var arr1=[]
$.each(arr, function(index, element){
//check for each element  whether it is empty string
if(element!=""){
//if it is push the letter a into the array arr1
arr1.push('a');
}
});
if($(arr1).length == $(".form-row input:not(:image)").length){
//if the number of elements of arr1 is equal to the number of elements of our dom selection, enable the button with submit class
$(".submit").attr("disabled",false);
}
console.log(arr1);
});

$("#process").click(function(e){
//when clicking the add more fields button, in case if the previous row of inputs are empty or at least some of them are empty
if(($("#pcnumber"+(x-1)).val()=="" || $("#pnumber"+(x-1)).val()=="")==true){
//deactivate the add more fields button
$("#process").prop("disabled", true);
//remove the previous fields intended for coupon number and account number
$("#pcnumber"+(x-1)).remove();
$("#pnumber"+(x-1)).remove();
/*In their place insert input text fields with the specified value bellow, 
when the visitor clicks some of these two fields, they will be removed and the button will be activated again*/
$('<input type="text" value="Required values" class="cn"/><input type="text" value="Required values" class="cn"/>').insertBefore("#pname"+(x-1));
if(($(".cn").val()=="Required values" || $("#pname"+(x-1))=="")==true)
{
$(".cn").click(function() {
$(".cn").remove();
$("#pname"+(x-1)).remove();
$("#pnl"+(x-1)).remove();
$("#process").prop("disabled", false);
});
}
}
      });
    });


var elements=[];
var i;
//on the base of the number of elements from the checkbox with a class: results, create an array of indexes
for(i=0;i<$("input:checkbox.results").length;i++){
elements[i]=i;
}
var a, b, element;
var strings=[];
$("input:checkbox.results").click(function(){

for(a=0,b=elements.length;a<b;a++){
element=elements[a];
/*on a click event, foreach member of that array check whether the checkbox is checked and 
whether the value of the id of the clicked checkbox matches one of the id values of the given checkboxes in the view*/
if($(this).is(":checked") && $(this).attr("id")==$("#results"+element).attr("id")){ 
//If it does push the string with the same id into the strings array
strings.push($("div#results"+element).text());
console.log(strings);
}
//basically what this does is the opposite from the logic above, in case if you uncheck the box remove its string from the array
if($(this).is(":not(:checked)") && $(this).attr("id")==$("#results"+element).attr("id")){
var ind=strings.indexOf($("div#results"+element).text());
strings.splice(ind,1);
console.log(strings);
}
}
//if the strings array is not empty keep the buttons with the selected ids bellow active, if it becomes empty deactivate them
if(strings.length>0){
$('#detach').attr('disabled',false);
$('#edit').attr('disabled',false);
}
if(strings.length==0){
$('#detach').attr('disabled',true);
$('#edit').attr('disabled',true);
}
//After the process of selection is finished transform them into a json string and put them into a hidden input field
$(".secret_one").val(JSON.stringify(strings));
}
);
var elementsOne=[];
for(var i=0;i < $("input:checkbox.editors").length;i++){
elementsOne[i]=i;
}
var elementOne;
var stringsOne=[];
$("input:checkbox.editors").click(function(){
for(var a=0;a<elementsOne.length;a++){
elementOne=elementsOne[a];
if($(this).is(":checked") && $(this).attr("id")==$("#editors"+elementOne).attr("id")){ 
stringsOne.push($("div#editors"+elementOne).text());
console.log(stringsOne);
}

if($(this).is(":not(:checked)") && $(this).attr("id")==$("#editors"+elementOne).attr("id")){
var indOne=stringsOne.indexOf($("div#editors"+elementOne).text());
stringsOne.splice(indOne,1);
console.log(stringsOne);
}
}

if(stringsOne.length>0){
$('#dismiss').attr('disabled',false);
}
if(stringsOne.length==0){
$('#dismiss').attr('disabled',true);
}

$(".secret_two").val(JSON.stringify(stringsOne));
}
);

var elementsTwo=[];
for(var i=0;i < $("input:checkbox.regulars").length;i++){
elementsTwo[i]=i;
}
var elementTwo;
var stringsTwo=[];
$("input:checkbox.regulars").click(function(){
for(var a=0;a<elementsTwo.length;a++){
elementTwo=elementsTwo[a];
if($(this).is(":checked") && $(this).attr("id")==$("#regulars"+elementTwo).attr("id")){ 
stringsTwo.push($("div#regulars"+elementTwo).text());
}

if($(this).is(":not(:checked)") && $(this).attr("id")==$("#regulars"+elementTwo).attr("id")){
var indTwo=stringsTwo.indexOf($("div#regulars"+elementTwo).text());
stringsTwo.splice(indTwo,1);
console.log(stringsTwo);
}

}

if(stringsTwo.length>0){
$('#add').attr('disabled',false);
}
if(stringsTwo.length==0){
$('#add').attr('disabled',true);
}
$(".secret_three").val(JSON.stringify(stringsTwo));
}
);

var cc=[];
//for each element that has this class on the edit view
$(".edit").each(function (){
//fill the empty cc array with the values of the attributes of those elements
  cc.push($(this).attr('id'));
});

var newarray=[];
while(cc.length>0){
//until the cc array becomes empty, slice the first three elements of the array and put them into other empty newarray array
//now this array will contain subarrays filled with the sliced or removed elements of the first array 
newarray.push(cc.splice(0,3));
}

var d=0;
/*"#cn"+d,"#an"+d,"#wn"+d are ids of the input fields located on the Processing.edit view. Cn, an and wn are the string
parts of the input fields ids. While d is the number part of the id.*/
/*If d is null, then all of the following rows comprised of input fields with partly identical ids will become read only.
(partly beacuse the string part is cn,an or wn, which is exactly the same as the string part of the ids from the first row. 
While the number part or the value of the id, designated for the next row, changes or increases in value by 1, in case
if the value of the input field with id "#cn"+d is changed)*/
$("#wn"+d).nextAll().attr('readonly', true);
var edit = {
// the route to which the ajax request is sent
source: "http://localhost:8000/coupon_search",
select: function(event, ui){
/*on the select event fill the input fields with the values of the properties configured in the json object which will be returned as a response from the server*/
$("#cn"+d).val(ui.item.value);
$("#an"+d).val(ui.item.account);
$("#wn"+d).val(ui.item.label);
},
minLength:1
};
$("#cn"+d).autocomplete(edit);

$('input[type="image"]').click(function(e){
//by clicking the image button you'll remove one row with input fields with the same class as the button
var y;
y=$(this).attr("class");
$("."+y).remove();
e.preventDefault();
});

//when some of the fields with the class edit is changed, an ajax request will be sent to the specified route
$(".edit").change(function(){

if($(this).val()==""){
$(".submit").attr("disabled",true);
}

if($(this).val()!=""){
$(".submit").attr("disabled",false);
}

$('input[type="image"]').click(function(e){
//by clicking the image button you'll remove one row with input fields with the same class as the button
var y;
y=$(this).attr("class");
$("."+y).remove();
e.preventDefault();
});
// ajax call is sent with the data from the form specified in the code bellow
//if the data entered matches certain data from the database, it means that the data we are trying to enter already exists  
$.ajax({
type:"post",
url:"/post_title",
data:{'date': $("#datepicker").val(),'meal' : $("#meal").val(), 'accountNumber': $("#an"+d).val(), 
'workerName': $("#wn"+d).val()},
dataType: "text",
success: function(data){
//If there are any results the input field from text type will be set with the returned data while the other two fields will be emptied
//d is reduced by one because when the success event activates d is already increased by 1
console.log(data);
$("#cn"+(d-1)).val(null);
$("#an"+(d-1)).val(null);
$("#wn"+(d-1)).val(data);
     },
error: function(jqXHR) {
/*If the coupons can't be found the returnIfProcessingDuplicate method will return inetrnal server error
because i'm trying to access the properties of the coupon and worker objects which in our case are null */
if (jqXHR.status == 500) {
console.log('The coupons are not duplicates, this is not an error :)');}}
});
//after the change of value in some of the fields ocures, we are increasing d by 1 
d++;
//if d is greater than 0 but smaller than the last index of the newarray array
//all previous and next fields or rows of fields should become read only, except for those fields whose numeric part's value
//is equal to the value of d
if(d>0 && d<(newarray.length-1)){
$("#cn"+d).prevAll().attr('readonly', true);
$("#wn"+d).nextAll().attr('readonly', true);
$("#cn"+d).attr('readonly', false);
$("#an"+d).attr('readonly', false);
$("#wn"+d).attr('readonly', false);
}
//if the value of d is equal to the last index of the newarray array
if(d==(newarray.length-1)){
// all the previous fields that icorporate the lesser value of d in their id should become readonly
$("#cn"+d).prevAll().attr('readonly', true);
$("#cn"+d).attr('readonly', false);
$("#an"+d).attr('readonly', false);
$("#wn"+d).attr('readonly', false);
}

var edit = {
// the route to which the ajax request is sent
source: "http://localhost:8000/edit_coupon_search",
select: function(event, ui){
/*on the select event fill the input fields with the values of the properties configured in the json object which will be returned as a response from the server*/
$("#cn"+d).val(ui.item.value);
$("#an"+d).val(ui.item.account);
$("#wn"+d).val(ui.item.label);
},
minLength:1
}
$("#cn"+d).autocomplete(edit);

});

//if the input field with id equal to meal is from text type and is not a select box, then the input with #month can
//become available for chainging value. This bacically reffers to the inputs from the createBD view, 
//where we can choose between breakfast and supper
if(($('#meal').attr('type')=='text')){
$("#month").prop("disabled", false);
}
else{
//while if the input with #meal is a select box and its value can be changed, on every change event enable the input with #month
$("#meal").change(function(e){
$("#month").prop("disabled", false);
});}

//when the input field with #month changes its value trigger the change event who calls a function that includes code
//that activates the button with class button
$("#month").change(function(e){
$(".button").prop("disabled", false);
//also after you select the proper month, am ajax post call is sent to the /motnh_meal route
//this request will be sending the values from the fields with #month and #meal ids
//those values will be saved in the database later
//you can see the method storeMonthMeal form the AutocompleteService for further explanation
$.ajax({
type:"post",
url:"/month_meal",
data:{'month': $("#month").val(), 'meal': $("#meal").val()},
dataType: "text",
success: function(data){
console.log(data);
      }
});
});
var arrayOne=[];
var arrayTwo=[];
var message= "Coupon/Account Numbers are already in place. "
$("form").submit(function(e){
//think of inputsC as a column of input fields that share the class inputsC
//the fields are the same from the distribution and the processing forms 
$(".inputsC").each(function(){
//take the values from each of the fields and put them into an array
arrayOne.push($(this).val());
});
//repeat the same steps with the fields that hold class inputsA
$(".inputsA").each(function(){
arrayTwo.push($(this).val());
});
//sort both arrays in an ascending order
sortedArrayOne=arrayOne.sort();
sortedArrayTwo=arrayOne.sort();
//for i starting from 0, which maximum iteration number can be a value less than the last index number of arrayOne, increment by 1
for (var i = 0; i < arrayOne.length - 1; i++) {
//if the value of the last index of the array is equal to the value of the last iteration number index of the array
//for both arrays 
if ((sortedArrayOne[i + 1] == sortedArrayOne[i])||(sortedArrayTwo[i + 1] == sortedArrayTwo[i])) {
e.preventDefault();
//first make sure that class par is not present
$(".par").remove();
//then apend the text paragraph with the same class to the div with form-row class
$(".form-row").append('<p class="par">'+message+'</p>');
//in each cycle store the values of each member that belongs to the arrays sortedArrayOne and sortedArrayTwo to variables x and z
var x=sortedArrayOne[i];
var z=sortedArrayTwo[i];
$("input.inputsC").each(function(){
//then select each field from the column of fields that hold the inputsC class and compare them to the current value of the x var
if($(this).val()==x){
//if they are equal, color the background of the fields red
$(this).css("background-color","red");
}
});
$("input.inputsA").each(function(){
// the same goes for inputsA and z variable
if($(this).val()==z){
$(this).css("background-color","red");
}
});
}
}
if($(".par")){
// now if you click on any of the fields holders of theese classes, the text paragraph that warned us will be removed
// the arrays will be emptied
// the red background color will disappear
$(".inputsC, .inputsA").click(function(){
$(".par").remove();
arrayOne=[];
sortedArrayOne=[];
arrayTwo=[];
sortedArrayTwo=[];
$(this).css("background-color","transparent");
});
}
});

$('#wname').keydown(function(){
var objectOne = {
minLength:3,
source: "http://localhost:8000/name_search",
select: function(event, ui){
$("#wname").val(ui.item.label);
$("#wname").val(ui.item.value);
}
};
$("#wname").autocomplete(objectOne);
});

//if the value of any of theese two fields changes disable the field with #calendar
$('#from, #to').change(function(){
$('#calendar').prop('disabled', true);
});
//the opposite from the above
$('#calendar').change(function(){
$('#from, #to').prop('disabled', true);
});



})

</script>
</body>
</html>
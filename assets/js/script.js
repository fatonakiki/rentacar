'use strict';

/**
 * navbar toggle
 */

const overlay = document.querySelector("[data-overlay]");
const navbar = document.querySelector("[data-navbar]");
const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");

const navToggleFunc = function () {
  navToggleBtn.classList.toggle("active");
  navbar.classList.toggle("active");
  overlay.classList.toggle("active");
}

navToggleBtn.addEventListener("click", navToggleFunc);
overlay.addEventListener("click", navToggleFunc);

for (let i = 0; i < navbarLinks.length; i++) {
  navbarLinks[i].addEventListener("click", navToggleFunc);
}



/**
 * header active on scroll
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  window.scrollY >= 10 ? header.classList.add("active")
    : header.classList.remove("active");
});

// register

function validateForm() {
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirmPassword").value;

  // checking if passwords don't match, if they don't they are not allowed to go further
  if (password !== confirmPassword) {
    alert("Passwords do not match!");
    return false;
  }
}


//admin panel
//manage cars
function showDialogForInsert() {
  document.getElementById("formAdd").reset(); //clear input fields 
  newCar.showModal(); //show the dialog
}

function showDialogForDelete(id) {
  deleteCar.showModal(); //show dialog
  var textId = document.querySelector('input[name="idToDelete"]');
  textId.value = id; //assign id to the field
}

function showDialogForEdit(id) {
  newCar.showModal();
  var selectedCar = phpResult.find(x=>x.vehicle_id == id); 
  var textLocation = document.querySelector('select[name="location"]');
  var textId = document.querySelector('input[name="id"]');
  var textType = document.querySelector('input[name="type"]');
  var textBrand = document.querySelector('input[name="brand"]');
  var textModel = document.querySelector('input[name="model"]');
  var textEngine = document.querySelector('input[name="engine"]');
  var textTransmission = document.querySelector('input[name="transmission"]');
  var textYear = document.querySelector('input[name="year"]');
  var textPrice = document.querySelector('input[name="price"]');

  //fill input fields with data from the row
  textLocation.value = selectedCar.location;
  textId.value = selectedCar.vehicle_id;
  textType.value = selectedCar.type;
  textBrand.value = selectedCar.brand;
  textModel.value = selectedCar.model;
  textEngine.value = selectedCar.engine;
  textTransmission.value = selectedCar.transmission;
  textYear.value = selectedCar.year;
  textPrice.value = selectedCar.price_per_day;

}

//make a booking
function addToBookings(id, price) {
  //if user isn't logged in or didn't fill all fields in search
  if (typeof bookData === 'undefined' || bookData === null) {
    alert("Please login (if you haven't so) and perform a search by filling all fields first!");
    return;
  }
  if (bookData[3] == '') {
    alert("Please login or create an account first!");
    return;
  }



  //show dialog
  addToBookingsDialog.showModal();

  //input fields
  var vehicle_id = document.querySelector('input[name="vehicle_id"]');
  var start_date = document.querySelector('input[name="start_date"]');
  var end_date = document.querySelector('input[name="end_date"]');
  var priceTxt = document.querySelector('input[name="price"]');

  //calculate days between dates
  const date1 = new Date(bookData[1]);
  const date2 = new Date(bookData[2]);
  const timeDiff = Math.abs(date2.getTime() - date1.getTime());
  const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

  //set the values of already selected dates and calculate the price for how many days
  vehicle_id.value = id;
  start_date.value = bookData[1];
  end_date.value = bookData[2];
  priceTxt.value = price * diffDays;

}
//manage bookings
function showEditDialogForBookings(id) {
  //show edit dialog
  editBooking.showModal();
  
  var selectedBooking = manageBookingData.find(x=>x.booking_id == id); 
  var manageId = document.querySelector('input[name="booking_id"]');
  var manageStartDate = document.querySelector('input[name="start_date"]');
  var manageEndDate = document.querySelector('input[name="end_date"]');
  var manageTotalPrice = document.querySelector('input[name="price"]');

  //set the values of already selected dates and calculate the price for how many days
  manageId.value = id;
  manageStartDate.value = selectedBooking.start_date;
  manageEndDate.value = selectedBooking.end_date;
  manageTotalPrice.value = selectedBooking.total_price;

}
function showDeleteDialogForBookings(id) {
  //show delete dialog
  deleteBooking.showModal();
  var textId = document.querySelector('input[name="idToDelete"]');
  textId.value = id;
}

function showDeleteDialogForUsers(id) {
  //show delete dialog
  deleteUser.showModal();
  var textUserId = document.querySelector('input[name="UseridToDelete"]');
  textUserId.value = id;
}
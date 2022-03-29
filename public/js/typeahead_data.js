$('#demo4').typeahead({
    source: function (query, result) {
        $.ajax({
            url: "/cities/list",
            data: 'query=' + query,            
            dataType: "json",
            type: "GET",
            success: function (data) {
                result($.map(data, function (item) {
                    return item;
                }));
            }
        });
    }
});

function showOwnerModal() {
  $("#hh-owner-regist-modal").modal('show');
}

function changeTitle(){
  $(".load-more-content").toggle('slow', function() {
    var currentTitle = Number($("#currentTitle").val());
    if(currentTitle == 1){
      $("#currentTitle").val(0);  
    }else{
      $("#currentTitle").val(1);  
    }
    if(currentTitle == 1){
        $("#loadButton").text("Load More");
    }else{
        $("#loadButton").text("Less Than");
    }
  });
}

function changeRule1Title(){
  $("#changeRule1Content").toggle('slow', function() {
    var currentTitle = Number($("#currentRule1Title").val());
    if(currentTitle == 1){
      $("#currentRule1Title").val(0);  
    }else{
      $("#currentRule1Title").val(1);  
    }
    if(currentTitle == 1){
        $("#rule1LoadMore").text("Load More");
    }else{
        $("#rule1LoadMore").text("Less Than");
    }
  });
}

function changeRule2Title(){
  $("#changeRule2Content").toggle('slow', function() {
    var currentTitle = Number($("#currentRule2Title").val());
    if(currentTitle == 1){
      $("#currentRule2Title").val(0);  
    }else{
      $("#currentRule2Title").val(1);  
    }
    if(currentTitle == 1){
        $("#rule2LoadMore").text("Load More");
    }else{
        $("#rule2LoadMore").text("Less Than");
    }
  });
}
// $("#demo4").on('focus', function(){
//     $.ajax({
//         url: '/cities/list',
//         method: 'GET',
//         data: {
//             query: $("#demo4").val()
//         },
//         success: function(res){
//             $("#demo4").typeahead({
//                 source: function(){
//                     return res;
//                 }
//             });
//         }
//     });
// });

$('#demo5').typeahead({
    source: function (query, result) {
        $.ajax({
            url: "/cities/list",
            data: 'query=' + query,            
            dataType: "json",
            type: "GET",
            success: function (data) {
                result($.map(data, function (item) {
                    return item;
                }));
            }
        });
    }
});

var checkStatus = function(label, val){
    var checkboxes = $("#"+label+ " :input");
    var result = '';
    for(var i = 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked == true){
            result += checkboxes[i].defaultValue + ",";
        }
    }
    result = result.slice(0, result.length-1);
    if(label == 'Home-Amenity'){
        $("#amenity_val").val(result);
    }else if(label == 'Home-Type'){
        $("#hometype_val").val(result);
    }
}

var checkFacility = function(){
    var checkboxes = $("#home-facilities :checked");
    var tmpName = "";
    var makeJson = {};
    var tmpArray = new Array();
    for(var i = 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked){
            var id = checkboxes[i].id;
            var f_name = id.split('_');
            f_name = f_name[0].replace("-", " ");
            if(tmpName != f_name) {
                if(tmpName != ""){
                    makeJson[tmpName] = tmpArray;
                }
                tmpName = f_name;
                tmpArray = new Array();
            }
            tmpArray.push(checkboxes[i].defaultValue);
        }
    }
    makeJson[tmpName] = tmpArray;
    console.log(makeJson);

    $("#facility_val").val(JSON.stringify(makeJson));

}

var checkSearchFacility = function() {
    var checkboxes = $("#home-facilities :checked");
    var tmpName = "";
    var makeJson = {};
    var tmpArray = new Array();
    for(var i = 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked){
            var id = checkboxes[i].id;
            var f_name = id.split('_');
            f_name = f_name[0].replace("-", " ");
            if(tmpName != f_name) {
                if(tmpName != ""){
                    makeJson[tmpName] = tmpArray;
                }
                tmpName = f_name;
                tmpArray = new Array();
            }
            tmpArray.push(checkboxes[i].defaultValue);
        }
    }
    makeJson[tmpName] = tmpArray;
    console.log(makeJson);

    $('input[name="home-facilities"]').val(JSON.stringify(makeJson));
}


function moveToSelected(element) {

  if (element == "next") {
    var selected = $(".selected").next();
  } else if (element == "prev") {
    var selected = $(".selected").prev();
  } else {
    var selected = element;
  }

  var next = $(selected).next();
  var prev = $(selected).prev();
  var prevSecond = $(prev).prev();
  var nextSecond = $(next).next();

  $(selected).removeClass().addClass("selected");

  $(prev).removeClass().addClass("prev");
  $(next).removeClass().addClass("next");

  $(nextSecond).removeClass().addClass("nextRightSecond");
  $(prevSecond).removeClass().addClass("prevLeftSecond");

  $(nextSecond).nextAll().removeClass().addClass('hideRight');
  $(prevSecond).prevAll().removeClass().addClass('hideLeft');
  
}
  
$('.prev1').click(function() {
  moveToSelected('prev');
});

$('.next1').click(function() {
  moveToSelected('next');
});

function resetPos() {
  $(".slider ul li").removeClass("transition");
  $(".slider ul li").removeClass("left1 right1");
}

//clicks
$(".prev").on("click", function () {
  $(".slider ul li").addClass("transition right1");

  setTimeout(function () {
    prev();
    resetPos();
  }, 500);
});

$(".next").on("click", function () {
  $(".slider ul li").addClass("transition left1");

  setTimeout(function () {
    next();
    resetPos();
  }, 500);
});
  
  ///////////////////////////////////////////////////////////////
  function init() {
    $(".slider ul li").each(function () {
      var curPos = $(this).index();
      $(this).css("order", curPos + 1);
    });
  }
  
  function prev() {
    var slider = $(".slider");
    var sliderLength = slider.find("ul li").length;
    $(".slider ul li").each(function () {
      var curPos = parseInt($(this).css("order"));
      var sliderLength = slider.find("ul li").length;
      if (curPos < sliderLength) {
        $(this).css("order", curPos + 1);
      } else {
        curPos = 1;
        $(this).css("order", curPos);
      }
    });
  }
  
  function next() {
    var slider = $(".slider");
    var sliderLength = slider.find("ul li").length;
    $(".slider ul li").each(function () {
      var curPos = parseInt($(this).css("order"));
      var sliderLength = slider.find("ul li").length;
      if (curPos > 0) {
        $(this).css("order", curPos - 1);
      } else {
        curPos = sliderLength - 1;
        $(this).css("order", curPos);
      }
    });
  }
  
  $(document).ready(function () {
    init();
  });

  var searchFunc = function() {
    $("#num_adults1").val($("#num_adults").val());
    $("#num_children1").val($("#num_children").val());
    $("#num_infants1").val($("#num_infants").val());
    $("#searchForm").submit();
  }

  

const galleryContainer = document.getElementById('featured_list_gallery');
const firstMinuteContainer = document.getElementById('first_minute_gallery');
const lastMinuteContainer = document.getElementById('last_minute_gallery');
const galleryControlsContainer = document.querySelector('.buttons');
const galleryControls = ['previous', 'add', 'next'];
const galleryItems = $("#featured_list_gallery > .gallery-item");
const firstMinuteGalleryItems = $("#first_minute_gallery > .gallery-item");
const lastMinuteGalleryItems = $("#last_minute_gallery > .gallery-item");
class Carousel {
  constructor(container, items, controls) {
    this.carouselContainer = container;
    this.carouselControls = controls;
    this.carouselArray = [...items];
  }

  // Update css classes for gallery
  updateGallery() {
    this.carouselArray.forEach(el => {
      el.classList.remove('gallery-item-1');
      el.classList.remove('gallery-item-2');
      el.classList.remove('gallery-item-3');
      el.classList.remove('gallery-item-4');
    });

    if(this.carouselArray.length >= 4) {
      this.carouselArray.slice(0, 3).forEach((el, i) => {
        el.classList.add(`gallery-item-${i+1}`);
      });
    }else if(this.carouselArray.length == 3) {
      this.carouselArray.slice(0, 3).forEach((el, i) => {
        el.classList.add(`gallery-item-${i+2}`);
      });
    }
  }

  // Update the current order of the carouselArray and gallery
  setCurrentState(direction) {

    if (direction.className == 'gallery-controls-previous') {
      this.carouselArray.unshift(this.carouselArray.pop());
    } else {
      this.carouselArray.push(this.carouselArray.shift());
    }
    
    this.updateGallery();
  }

  // Construct the carousel navigation
  // setNav() {
    // galleryContainer.appendChild(document.createElement('ul')).className = 'gallery-nav';

    // this.carouselArray.forEach(item => {
    //   const nav = galleryContainer.lastElementChild;
    //   nav.appendChild(document.createElement('li'));
    // }); 
  // }s

  // Construct the carousel controls
  // setControls() {
  //   this.carouselControls.forEach(control => {
  //     galleryControlsContainer.appendChild(document.createElement('button')).className = `gallery-controls-${control}`;

  //     document.querySelector(`.gallery-controls-${control}`).innerText = control;
  //   });
  // }
 
  // Add a click event listener to trigger setCurrentState method to rearrange carousel
  useControls() {
    var triggers = [...$("#galler_buttons > a")];
    triggers.forEach(control => {
      control.addEventListener('click', e => {
        e.preventDefault();

        if (control.className == 'gallery-controls-add') {
          const newItem = document.createElement('img');
          const latestItem = this.carouselArray.length;
          const latestIndex = this.carouselArray.findIndex(item => item.getAttribute('data-index') == this.carouselArray.length)+1;

          // Assign the necessary properties for new gallery item
          Object.assign(newItem,{
            className: 'gallery-item',
            src: `http://fakeimg.pl/300/?text=${this.carouselArray.length+1}`
          });
          newItem.setAttribute('data-index', this.carouselArray.length+1);

          // Then add it to the carouselArray and update the gallery
          this.carouselArray.splice(latestIndex, 0, newItem);
          document.querySelector(`[data-index="${latestItem}"]`).after(newItem);
          this.updateGallery();

        } else {
          this.setCurrentState(control);
        }

      });
    });
  }
}

const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);
const firstMinuteCarousel = new Carousel(firstMinuteContainer, firstMinuteGalleryItems, galleryControls);
const lastMinuteCarousel = new Carousel(lastMinuteContainer, lastMinuteGalleryItems, galleryControls);
// exampleCarousel.setControls();
// exampleCarousel.setNav();
exampleCarousel.useControls();
firstMinuteCarousel.useControls();
lastMinuteCarousel.useControls();



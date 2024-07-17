let menuCards = document.querySelectorAll('.menu_card');
let subCategories = document.querySelector('.sub_categories');
let contentSub = document.querySelectorAll('.content_sub .btn');
let products = document.querySelectorAll('.products .box');


// contentSub.forEach((card)=>{
//   card.addEventListener('click',mange);
// })


// function mange() {
//   contentSub.forEach((sub)=>{
//     sub.style.display = 'block'
//   })
//   products.forEach((product)=>{
//     product.style.display = 'none'
//   })

//   document.querySelectorAll(this.dataset.choose).forEach((el)=>{
//     el.style.display = 'block'
//   })
// }

function mangeBouquets(name) {
  var div=document.getElementById(name);

  contentSub.forEach((sub)=>{
    sub.style.display = 'none'
  })
  products.forEach((product)=>{
    product.style.display = 'none'
  })

  document.querySelectorAll('.'+name).forEach((el)=>{
    if(div.classList.contains('active'))
    {
      el.style.display = 'block';

    }else{
      contentSub.forEach((sub)=>{
        sub.style.display = 'block';
      })

    }

    
  })
}

// menuCards.forEach((card)=>{
//   card.addEventListener('click',removeActive)
// })

// menuCards.forEach((card)=>{
//   card.addEventListener('click',toggle)
// })

// function removeActive() {
//   menuCards.forEach((slide)=>{
//     slide.classList.remove('active');
//     this.classList.add('active');
//   })
  
// }

function toggle(clickedElement) {
alert(clickedElement);
var div=document.getElementById(clickedElement);
div.classList.toggle('active');
mangeBouquets(clickedElement);
}

let langEn = document.querySelector('.dropdown .en');
let langAr = document.querySelector('.dropdown .ar');

langEn.addEventListener('click', changeLangToEnglish)
langAr.addEventListener('click', changeLangToArabic)

function changeLangToEnglish() {
  if (langEn.innerHTML ===  "English") {
    document.body.dir = 'rtl';
  } 
  handleActive()
}


function changeLangToArabic() {
  if(langAr.innerHTML ===  "Arabic") {
    document.body.dir = 'ltr';
  }
  handleActive()
}

function handleActive() {
  document.querySelector('.dropdown').classList.remove('active')
  document.querySelector('.dropdown').style.transition = "all 0s";
  document.querySelector('.fa-globe').classList.remove('active')
}

let lang = document.querySelector('.lang i');
let profile = document.querySelector('.profile .info');

lang.addEventListener('click',()=>{
  document.querySelector('.fa-globe').classList.toggle('active')
  document.querySelector('.dropdown').classList.toggle('active')
  document.querySelector('.dropdown_personal').classList.remove('active')
})

profile.addEventListener('click',()=>{
  document.querySelector('.dropdown_personal').classList.toggle('active')
  document.querySelector('.dropdown').classList.remove('active')
  document.querySelector('.fa-globe').classList.remove('active')
})


let nextBtn = document.querySelectorAll('.next-stp');
let prevBtn = document.querySelectorAll('.prev-stp');
let steps = document.querySelectorAll('.step');
let stps = document.querySelectorAll('.stp');
let currentStep = 0; // المتغير الذي يتحكم في الخطوة الحالية

// الوظيفة التي تقوم بإظهار الخطوة وإضافة/إزالة فئة "active"
function showStep(stepIndex) {
  stps.forEach((stp, index) => {
    if (index === stepIndex) {
      stp.style.display = 'flex';
    } else {
      stp.style.display = 'none';
    }
  });

  currentStep = stepIndex; // تحديث الخطوة الحالية

    steps.forEach((step, index) => {
    if (index === stepIndex) {
      step.classList.add('active');
    } else {
      step.classList.remove('active');
    }
  });
}

// تابع النقر للأزرار التالية
nextBtn.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    if (currentStep < stps.length - 1) {
      showStep(currentStep + 1);
    }
  });
});

// تابع النقر للأزرار السابقة
prevBtn.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    if (currentStep > 0) {
      showStep(currentStep - 1);
    }
  });
});

// ابدأ بعرض الخطوة الأولى
showStep(0);

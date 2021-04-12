<template>
  <form class="Text-field" ref="foormElement" @submit.prevent="sendForm">
    <label class="formTitle">{{ foormTitle }}</label>

    <div class="input_container_wrapper">

      <label for="input_name" class="label_bakground"></label>
      <label for="input_name" class="form_label">{{ lamelNameText }}</label>

      <input ref="foormInputName" name='input' type="text" id="input_name" class="form_input" >

      <p class='formError' v-if="errorText.nameEr">
        <img :src="errror_img">
        <span>{{ errorText.nameEr }}</span>
      </p>

    </div>
    <div class="input_container_wrapper">

      <label for="input_phone" class="label_bakground"></label>
      <label for="input_phone" class="form_label">{{ labelPhoneText }}</label>

      <input  ref="foormInputPhone" name='input' type="text" id="input_phone" class="form_input">

      <p class='formError'  v-if="errorText.phoneEr">
        <img :src="errror_img" >
        <span>{{errorText.phoneEr}}</span>
      </p>

    </div>

    <div class="text_wrapper">
      <label for="input_textArea" class="label_textArea">{{ labelText }}</label>

      <textarea ref="foormInputText" id="input_textArea" rows="4" cols="85"> </textarea>

      <p class='formError'  v-if="errorText.textEr">
        <img :src="errror_img" >
        <span>{{errorText.textEr}}</span>
      </p>

    </div>

    <button class="form_submit_button" type="submit">{{ submitBtnText }}</button>

  </form>
</template>


<script>

import { onMounted, ref } from 'vue';
import imageError from "../assets/icons-16-icon-input-error.svg"

export default {
  name: 'Form',

  setup(){

    let foormElement    = ref(null);

    let foormInputName  = ref(null);
    let foormInputPhone = ref(null);
    let foormInputText  = ref(null);
    let errorText       = ref({ nameEr:'', phoneEr:'', textEr:'' });

    let foormTitle     = ref('Обратная связь');
    let lamelNameText  = ref('Имя');
    let labelPhoneText = ref('Телефон');
    let labelText      = ref('Сообщение');
    let submitBtnText  = ref('Отправить');

    let errror_img = imageError;


    onMounted(()=>{
      styleFormIputWrapper(foormElement);
    })


    function styleFormIputWrapper (refForm){


      let formChildren = refForm.value.childNodes

      Object.keys(formChildren).map((key)=>{

        let parrent = formChildren[key];
        let inputEl = parrent.children.namedItem('input');;
        let labelEl = parrent.children[1];

        if( !labelEl || !inputEl ) return

        inputEl.addEventListener ( 'focus', ()=>{

          parrent.classList.add("input_container_wrapper_on_focus");
          labelEl.classList.add("form_label_focused");
          labelEl.classList.remove("form_label");
        });

        inputEl.addEventListener ( 'blur', ()=>{


          if( !inputEl.value.length ){
            parrent.classList.remove("input_container_wrapper_on_focus");
            labelEl.classList.remove("form_label_focused");
          }

          labelEl.classList.add("form_label");


        });

      })

    }
    const  sendForm = async ()=>{
      let nameVal  = foormInputName.value.value;
      let phoneVal = foormInputPhone.value.value;
      let textVal  = foormInputText.value.value;

      var formData = new FormData();
          formData.append('name', nameVal);
          formData.append('phone_number', phoneVal);
          formData.append('text', textVal );

      const myHeaders = {
          method : 'POST',
          headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': window.Laravel.csrfToken
          },
          body   : formData
      };

      const response = await fetch('/formFeedBack', myHeaders);

      if( response.status === 422 ){

        let resp = await response.json();

        errorText.value.nameEr  = '';
        errorText.value.phoneEr = '';
        errorText.value.textEr = '';

        if(resp.errors.name)
          errorText.value.nameEr = resp.errors.name[0];
        if(resp.errors.phone_number)
          errorText.value.phoneEr = resp.errors.phone_number[0];
        if(resp.errors.text)
          errorText.value.textEr = resp.errors.text[0];
      }

    }


    return{

      foormElement, foormInputName, foormInputPhone, foormInputText,
      errror_img, errorText,
      lamelNameText, labelPhoneText, submitBtnText, foormTitle, labelText,
      sendForm
    }
  }
}


</script>



<style scoped lang="scss">

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');

/**   [ Table Of Contebts ]

  1 - Mixins
  2 - Form Styling
  3 - Mause events
*/



//--Mixins
@mixin standartFontStyle(){
  font-family  : 'Roboto', sans-serif;
  font-weight  : normal;
  font-stretch : normal;
  font-style   : normal;
}
@mixin setPosition($position, $deltaX:0px, $deltaY:0px){

  position: absolute;

  @if $position == "x-move-y-center"{

    top       : 50%;
    left      : 0;
    transform : translate( $deltaX, -50% );
  }
  @if $position == "move-top-left"{

    top       : 0;
    left      : 0;
    transform : translate($deltaX, 0);
  }


}
@mixin animateFrame($name, $duration:'0.7s', $timing: 'ease-in-out'){

  $positionOrigin    : 'left top';

	animation-name             : #{$name};
	animation-duration         : #{$duration};
  transition-timing-function : #{$timing};
  animation-fill-mode        : forwards;
  // animation-fill-mode        : both;
	// animation-direction   : #{$timing};


  @if $name == "labaelUp"{

    transform-origin : center, center;

    @keyframes #{$name}{
      from{
        top       : 50%;
        left      : 50%;
        transform : translate( -50%, -50%);
      }
      to {
        top       : 5px;
        left      : 16px;
        transform : translate(0, 0);
      }

    }
  }
  @if $name == "opacity"{
    @keyframes #{$name}{
      from  { opacity: 0;}
      to    { opacity: 1;}
    }
  }
   @if $name == "scale"{
    @keyframes #{$name}{
      from  { font-size: 15px;}
      to    { font-size: 13px;;}
    }
  }

}


//--Form Styling
form{
  @include standartFontStyle();

  width            : 798px;
  height           : auto;
  margin-top       : 20px;
  padding          : 39px 14px 39px 61px;
  background-color : #0d0f17;
  margin-inline    : auto;
  border-radius    : 4px;
}

.formTitle{

  height         : 24px;
  margin         : 0 290px 20px 0;
  font-size      : 16px;
  font-weight    : 600;
  line-height    : 1.5;
  letter-spacing : normal;
  color          : #ffffff;

  display        : block;
}

.input_container_wrapper{
  position: relative;
  display : block;
  width   : 352px;
  height  : 48px;
  margin  : 3px 10px 25px 0px;
  padding : 2px 0 0;

  border-bottom : 0.2px solid #6b6c7b;
  box-sizing    : border-box;
}
.label_bakground::before{
  width            : 352px;
  height           : 44px;
  padding          : 2px 0 0;
  opacity          : 0.15;
  border-radius    : 4px 4px 0 0;
  background-color : #848595;

  position : absolute;
  content  : '';
}
.input_container_wrapper_on_focus{
  border-bottom : 2px solid #006ac7!important;
}

.text_wrapper{

  display        : flex;
  flex-direction : column;

  position: relative;

  margin         : 3px 10px 25px 0px;
  padding        : 2px 0 0;
  font-size      : 16px;
  line-height    : 1.5;
  letter-spacing : normal;
  color          : #9d9daf;

  box-sizing    : border-box;

  textarea{
    border-radius    : 4px 4px 0 0;
    background-color : #2a2c38;
    color            : #9d9daf;
    padding          : 5px;

  }

}


.form_label{
  @include setPosition('x-move-y-center', 16px);

  width          : 320px;
  height         : 24px;
  margin-top     : 0;
  font-size      : 16px;
  line-height    : 1.5;
  letter-spacing : normal;
  color          : #9d9daf;

}
.form_label_focused{
  @include setPosition('move-top-left', 16px);
  @include animateFrame("labaelUp", '0.5s', 'ease-out');


  width          : 320px;
  height         : 16px;
  margin         : 0;
  font-size      : 12px;
  line-height    : 1.33;
  letter-spacing : normal;
  color          : #9d9daf;
}
.form_input{

  width          : 320px;
  height         : 24px;
  margin         : 18px 16px 4px;
  font-size      : 16px;
  line-height    : 1.5;
  letter-spacing : normal;
  color          : #ffffff;

  visibility       : visible;
  display          : block;
  background-color : inherit;
  text-overflow    : ellipsis;
  border           : 0;
  outline          : 0;
  padding          : 0;

}
.form_input_focus{
  visibility: hidden;
}


.formError{
  @include animateFrame('scale', '0.5s');

  display : flex;
  margin  : 8px 0 0;

  .img{
    width      : 16px;
    height     : 16px;
    margin     : 2px 4px 2px 0;
    object-fit : contain;
  }
  span{
    width          : 332px;
    height         : 20px;
    margin         : 0 0 0 4px;
    line-height    : 1.54;
    letter-spacing : normal;
    color          : #e84640;
  }

}

.form_submit_button{
  background-color : #006ac7;
  color            : #ffffff;
  margin-top       : 6px;
  padding          : 12px;
  width            : 100px;
  border           : 0;
  border-radius    : 5px;
  outline          : 0;
  cursor           : pointer;
}


//--Mause events
.input_container_wrapper:hover{
  border-bottom: 0.5px solid #848595;
}
.input_container_wrapper:hover > .label_bakground::before{
  opacity: 0.25;
}

.form_submit_button:hover{
  background-color : #0c7de0;
}
.form_submit_button:active{
  background-color : #006ac7;
}

</style>

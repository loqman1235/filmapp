<div class="register_page">
      <div class="register">
        <h1>Create a new account</h1>
        <form  class="registerForm" id="registerForm">
          <span class="input_success" id="registerSuccess"></span>
          <div class="form_group">
            <input type="text" name="uname" id="uname" placeholder=" " />
            <label for="uname">Username</label>
          </div>
          <span class="input_error" id="uname_error"></span>

          <div class="form_group">
            <input type="text" name="uemail" id="uemail" placeholder=" " />
            <label for="uemail">Email</label>
          </div>
          <span class="input_error" id="uemail_error"></span>

          <div class="form_group">
            <input
              type="password"
              name="pwd"
              id="pwd"
              autocomplete="off"
              placeholder=" "
            />
            <label for="pwd">Confirm password</label>
          </div>
          <span class="input_error" id="pwd_error"></span>

          <div class="form_group">
            <input
              type="password"
              name="confpwd"
              id="confpwd"
              autocomplete="off"
              placeholder=" "
            />
            <label for="confpwd">Password</label>
          </div>
          <span class="input_error" id="confpwd_error"></span>

          <button type="submit" class="btn btn_secondary">Register</button>
        </form>
      </div>
    </div>



<script type="module">
import { randProfilePicture } from "<?= base_url() ?>assets/js/libs/Functions.js";

const registerForm = document.getElementById('registerForm');

const uname = document.getElementById('uname');
const uemail = document.getElementById('uemail');
const pwd = document.getElementById('pwd');
const confpwd = document.getElementById('confpwd');

// Errors
const uname_error = document.getElementById('uname_error');
const uemail_error = document.getElementById('uemail_error');
const pwd_error = document.getElementById('pwd_error');
const confpwd_error = document.getElementById('confpwd_error');

// Success
const registerSuccessMsg = document.getElementById('registerSuccess')


const registerUser = async (e) => {

  e.preventDefault();
  
  let formData = new FormData();
  formData.append('uname', uname.value);
  formData.append('uemail', uemail.value);
  formData.append('pwd', pwd.value);
  formData.append('confpwd', confpwd.value);
  (uname.value !== '') ? formData.append('defaultPfp', randProfilePicture(uname.value)) : false;

  const response = await fetch('register/registerUser', {
    method: 'POST', 
    body: formData,
  });
  const result = await response.json();

  if(result.error) 
  {
    if(result.uname_error !== '')
    {
      uname_error.innerHTML = result.uname_error;
      uname_error.previousElementSibling.firstElementChild.classList.add('border-danger');
    }
    else
    {
      uname_error.innerHTML = '';
      uname_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    }

    if(result.uemail_error !== '')
    {
      uemail_error.innerHTML = result.uemail_error;
      uemail_error.previousElementSibling.firstElementChild.classList.add('border-danger');
    }
    else
    {
      uemail_error.innerHTML = '';
      uemail_error.previousElementSibling.firstElementChild.classList.remove('border-danger');

    }

    if(result.pwd_error !== '')
    {
      pwd_error.innerHTML = result.pwd_error;
      pwd_error.previousElementSibling.firstElementChild.classList.add('border-danger');
    }
    else
    {
      pwd_error.innerHTML = '';
      pwd_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    }

    if(result.confpwd_error !== '')
    {
      confpwd_error.innerHTML = result.confpwd_error;
      confpwd_error.previousElementSibling.firstElementChild.classList.add('border-danger');
    }
    else
    {
      confpwd_error.innerHTML = '';
      confpwd_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    }

  }

  if(result.success)
  {

    
    uname_error.innerHTML = '';
    uemail_error.innerHTML = '';
    pwd_error.innerHTML = '';
    confpwd_error.innerHTML = '';
    
    uname_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    uemail_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    pwd_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    confpwd_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
    
    registerSuccessMsg.innerHTML = result.successMsg;
    registerForm.reset();
   
    setInterval(() => {
      registerSuccessMsg.remove();
      setInterval(() => {
        document.location = '<?= base_url('login') ?>';
      }, 2000);
    }, 2000);


  }


}


registerForm.addEventListener('submit', registerUser);

</script>


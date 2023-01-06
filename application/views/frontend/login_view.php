<div class="login_page">
      <div class="login">
        <h1>Login to your account</h1>
        <form action="#" class="loginForm" id="loginForm">
          <span id="errorMsgLogin" class="input_error"></span>
          <div class="form_group">
            <input type="text" name="uname" id="uname" placeholder=" " />
            <label for="uname">Username</label>
          </div>
          <span class="input_error" id="uname_error"></span>

          <div class="form_group">
            <input
              type="password"
              name="pwd"
              id="pwd"
              autocomplete="off"
              placeholder=" "
            />
            <label for="pwd">Password</label>
          </div>
          <span class="input_error" id="pwd_error"></span>

          <button type="submit" class="btn btn_secondary">Login</button>
        </form>
      </div>
    </div>


<script>

const loginForm  = document.getElementById('loginForm');
const uname = document.getElementById('uname');
const pwd   = document.getElementById('pwd');

// Errors 
const uname_error = document.getElementById('uname_error');
const pwd_error   = document.getElementById('pwd_error');
const errorMsgLogin = document.getElementById('errorMsgLogin');



const loginUser = async(e) =>
{
        e.preventDefault();

        let formData = new FormData();
        formData.append('uname', uname.value);
        formData.append('pwd', pwd.value);  

        const response = await fetch('login/loginUser', {
            method: 'POST',
            body: formData
        });


        const result = await response.json();


        if(result.error)
        {
            if(result.uname_error !== '' && result.uname_error !== undefined)
            {
                uname_error.innerHTML = result.uname_error;
                uname_error.previousElementSibling.firstElementChild.classList.add('border-danger');
            }
            else
            {
                uname_error.innerHTML = '';
                uname_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
            }

            if(result.pwd_error !== '' && result.pwd_error !== undefined)
            {
                pwd_error.innerHTML = result.pwd_error;
                pwd_error.previousElementSibling.firstElementChild.classList.add('border-danger');
            }
            else
            {
                pwd_error.innerHTML = '';
                pwd_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
            }

            if(result.login_error !== '' && result.login_error !== undefined)
            {
                errorMsgLogin.innerHTML = result.login_error;
            }
            else
            {
                errorMsgLogin.innerHTML = "";
            }

        }

        if(result.success)
        {
            console.log(result.success);
            uname_error.innerHTML = '';
            pwd_error.innerHTML = '';
            errorMsgLogin.innerHTML = "";

            uname_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
            pwd_error.previousElementSibling.firstElementChild.classList.remove('border-danger');
            loginForm.reset();
            
            // redirect to homepage
            document.location.href = 'home'

        }
}


loginForm.addEventListener('submit', loginUser);


</script>
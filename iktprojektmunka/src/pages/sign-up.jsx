import {
  Input,
  Checkbox,
  Button,
  Typography,
} from "@material-tailwind/react";
import { Link, useNavigate  } from "react-router-dom";
import axios from 'axios'


export function SignUp() {
  const navigate = useNavigate();
  function elkuld()
  {
    axios({
      method: "post",
      url: "http://localhost/levi/php/sign-up.php",
      data: {
          email: document.getElementById("email").value,
          password: document.getElementById("password").value,
      }
      })
      .then( function (response) {
          setTimeout(() => {
            navigate("/sign-in");
          }, 2000);
      })
      .catch(function (error) {
          console.log(error);
      });
  }
  return (
    <section className="m-8 flex">
            <div className="w-2/5 h-full hidden lg:block">
        <img
          src="/img/B1pppR4gVKL._CLa_2140,2000_61LPDJurxiL.png_0,0,2140,2000+0.0,0.0,2140.0,2000.0_AC_UY1000_.jpg"
          className="h-full w-full object-cover rounded-3xl"
        />
      </div>
      <div className="w-full lg:w-3/5 flex flex-col items-center justify-center">
        <div className="text-center">
          <Typography variant="h2" className="font-bold mb-4">Join Us Today</Typography>
          <Typography variant="paragraph" color="blue-gray" className="text-lg font-normal">Enter your email and password to register.</Typography>
        </div>
        <form className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2">
          <div className="mb-1 flex flex-col gap-6">
            <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
              Your email
            </Typography>
            <Input id="email"
              size="lg"
              placeholder="name@mail.com"
              className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
              labelProps={{
                className: "before:content-none after:content-none",
              }}
            />
            <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
              Password
            </Typography>
            <Input id="password"
              type="password"
              size="lg"
              placeholder="password12345"
              className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
              labelProps={{
                className: "before:content-none after:content-none",
              }}
            />
          </div>
          <Checkbox
            label={
              <Typography
                variant="small"
                color="gray"
                className="flex items-center justify-start font-medium"
              >
                I agree the&nbsp;
                <a
                  href="#"
                  className="font-normal text-black transition-colors hover:text-gray-900 underline"
                >
                  Terms and Conditions
                </a>
              </Typography>
            }
            containerProps={{ className: "-ml-2.5" }}
          />
          <Button className="mt-6" fullWidth onClick={elkuld}>
            Register Now
          </Button>
          <Typography variant="paragraph" className="text-center text-blue-gray-500 font-medium mt-4">
            Already have an account?
            <Link to="/sign-in" className="text-gray-900 ml-1">Sign in</Link>
          </Typography>
        </form>
      <div divclassName="mt-8 text-center">
       ide kellene h ha beirja az emailt elkuldje sqlbe utanna kerje tole a jelszot azt is elkuldje sqlbe
      </div>
      </div>
    </section>
  );
}

export default SignUp;
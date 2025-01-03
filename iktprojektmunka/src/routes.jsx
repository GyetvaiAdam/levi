import { Home, Profile, SignIn, SignUp } from "@/pages";
import { Test } from "@/pages";

export const routes = [
  {
    name: "home",
    path: "/home",
    element: <Home />,
  },
  {
    name: "your tests",
    path: "/tests",
    element: <Profile />,
  },
  {
    name: "Sign In",
    path: "/sign-in",
    element: <SignIn />,
  },
  {
    name: "Sign Up",
    path: "/sign-up",
    element: <SignUp />,
  },
  {
    name: "About us",
    href: "",
    target: "_blank",
    element: "",
  },
  {
    name: "The Test",
    path: "/test",
    element: <Test />,
  }
];

export default routes;

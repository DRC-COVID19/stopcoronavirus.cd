import Home from "./pages/Home";
import Login from './pages/Login';
export default [
    {
        name: "login",
        path: "/dashboard-maps/login",
        component: Login
    },
    {
        name: "home",
        path: "/dashboard-maps",
        component: Home,
        meta: {
            requiresAuth: true
        }
    }
];
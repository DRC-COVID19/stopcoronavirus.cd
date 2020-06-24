import Home from "./pages/Home";
import Login from './pages/Login';
import LostPassword from './pages/LostPassword';
export default [
    {
        name: "login",
        path: "/dashboard-maps/login",
        component: Login
    },
    {
        name: "lostPassword",
        path: "/dashboard-maps/lost-password",
        component: LostPassword
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
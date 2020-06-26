import Home from "./pages/Home";
import Login from './pages/auth/Login';
import LostPassword from './pages/auth/LostPassword';
import ResetPasswordThank from './pages/auth/ResetPasswordThank';
import ResetPasseword from './pages/auth/ResetPassword';
import PasswordResetComplete from './pages/auth/PasswordResetComplete';
import FilterFlux from './components/filters/Flux';
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
        name: "password.reset.thanks",
        path: "/dashboard-maps/lost-password-send",
        component: ResetPasswordThank
    },
    {
        name: "password.reset.token",
        path: "/dashboard-maps/password-reset/:token",
        component: ResetPasseword
    },
    {
        name: "password.reset.complete.thanks",
        path: "/dashboard-maps/password-reset/complete",
        component: PasswordResetComplete
    },
    {
        path: "/dashboard-maps",
        component: Home,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                name: "home",
                components: {
                    filter: FilterFlux,
                }
            }
        ]
    }
];

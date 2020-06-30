import Home from "./pages/Home";
import Login from './pages/auth/Login';
import LostPassword from './pages/auth/LostPassword';
import ResetPasswordThank from './pages/auth/ResetPasswordThank';
import ResetPasseword from './pages/auth/ResetPassword';
import PasswordResetComplete from './pages/auth/PasswordResetComplete';
import HospitalsHome from './pages/hospital/Home';
import HospitalsCreate from './pages/hospital/HospitalCreate';
import HospitalsDetail from './pages/hospital/HospitalDetail';
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
        name: "home",
        meta: {
            requiresAuth: true
        },
    },
    {
        path: "/dashboard-maps/hospitals",
        name: "hospital.home",
        component: HospitalsHome,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: "/dashboard-maps/hospitals/new",
        name: "hospital.create",
        component: HospitalsCreate,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: "/dashboard-maps/hospitals/show/:hospital_id",
        name: "hospital.detail",
        component: HospitalsDetail,
        meta: {
            requiresAuth: true
        },
    }
];

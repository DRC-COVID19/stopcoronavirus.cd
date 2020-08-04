import Home from "./pages/Home";
import Login from './pages/auth/Login';
import LostPassword from './pages/auth/LostPassword';
import ResetPasswordThank from './pages/auth/ResetPasswordThank';
import ResetPasseword from './pages/auth/ResetPassword';
import PasswordResetComplete from './pages/auth/PasswordResetComplete';
import HospitalsHome from './pages/hospital/Home';
import HospitalsCreate from './pages/hospital/HospitalCreate';
import HospitalsDetail from './pages/hospital/HospitalDetail';
import HospitalData from './pages/hospital/HospitalData';
import HospitalAdmin from './pages/adminHospital/Home';
import HospitalAdminData from './pages/adminHospital/HospitalData';
import NotAcces from './pages/NotAccess';
import Landing from './pages/Landing';

const adminDashboard = "admin-dashboard";
const agentHospital = "agent-hospital";
const adminHospital = "admin-hospital";

export default [
    {
        name: "login",
        path: "/dashboard-maps/login",
        component: Login,

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
            requiresAuth: true,
            role: [adminDashboard]
        },
    },
    {
        path: "/dashboard-maps/hospitals",
        name: "hospital.home",
        component: HospitalsHome,
        meta: {
            requiresAuth: true,
            role: [agentHospital]
        },
    },
    {
        path: "/dashboard-maps/admin/hospitals",
        name: "hospital.admin",
        component: HospitalAdmin,
        meta: {
            requiresAuth: true,
            role: [adminHospital]
        },
    },
    {
        path: "/dashboard-maps/admin/hospitals/:hospital_id",
        name: "hospital.admin.data",
        component: HospitalAdminData,
        meta: {
            requiresAuth: true,
            role: [adminHospital]
        },
    },
    {
        path: "/dashboard-maps/hospitals/data",
        name: "hospital.data",
        component: HospitalData,
        meta: {
            requiresAuth: true,
            role: [agentHospital]
        },
    },
    {
        path: "/dashboard-maps/hospitals/new",
        name: "hospital.create",
        component: HospitalsCreate,
        meta: {
            requiresAuth: true,
            role: [agentHospital]
        },
    },
    {
        path: "/dashboard-maps/hospitals/:hospital_id/show/:update_id",
        name: "hospital.detail",
        component: HospitalsDetail,
        meta: {
            requiresAuth: true,
            role: [agentHospital,adminHospital]
        },
    },
    {
        path: "/dashboard-maps/hospitals/edit/:hospital_id",
        name: "hospital.edit",
        component: HospitalsCreate,
        meta: {
            requiresAuth: true,
            role: [agentHospital]
        },
    },
    {
        path: "/dashboard-maps/acces-denied",
        name: "acces.denied",
        component: NotAcces,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/dashboard-maps/landing",
        name: "landing",
        component: Landing,
        meta: {
            requiresAuth: true
        },
    }
];

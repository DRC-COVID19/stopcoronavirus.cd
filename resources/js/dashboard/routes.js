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
import Administrator from './pages/Administrator';
import AdminUserIndex from './pages/administrator/users/Index';
import AdminUserCreate from './pages/administrator/users/Create';

const adminDashboard = "admin-dashboard";
const agentHospital = "agent-hospital";
const adminHospital = "admin-hospital";

export default [
  {
    name: "login",
    path: "/login",
    component: Login,

  },
  {
    name: "lostPassword",
    path: "/lost-password",
    component: LostPassword
  },
  {
    name: "password.reset.thanks",
    path: "/lost-password-send",
    component: ResetPasswordThank
  },
  {
    name: "password.reset.token",
    path: "/password-reset/:token",
    component: ResetPasseword
  },
  {
    name: "password.reset.complete.thanks",
    path: "/password-reset/complete",
    component: PasswordResetComplete
  },
  {
    path: "/",
    component: Home,
    name: "home",
    meta: {
      requiresAuth: true,
      role: [adminDashboard]
    },
  },
  {
    path: "/hospitals",
    name: "hospital.home",
    component: HospitalsHome,
    meta: {
      requiresAuth: true,
      role: [agentHospital]
    },
  },
  {
    path: "/admin/hospitals",
    name: "hospital.admin",
    component: HospitalAdmin,
    meta: {
      requiresAuth: true,
      role: [adminHospital]
    },
  },
  {
    path: "/admin/hospitals/:hospital_id",
    name: "hospital.admin.data",
    component: HospitalAdminData,
    meta: {
      requiresAuth: true,
      role: [adminHospital]
    },
  },
  {
    path: "/hospitals/data",
    name: "hospital.data",
    component: HospitalData,
    meta: {
      requiresAuth: true,
      role: [agentHospital]
    },
  },
  {
    path: "/hospitals/new",
    name: "hospital.create",
    component: HospitalsCreate,
    meta: {
      requiresAuth: true,
      role: [agentHospital]
    },
  },
  {
    path: "/hospitals/:hospital_id/show/:update_id",
    name: "hospital.detail",
    component: HospitalsDetail,
    meta: {
      requiresAuth: true,
      role: [agentHospital, adminHospital]
    },
  },
  {
    path: "/hospitals/edit/:hospital_id",
    name: "hospital.edit",
    component: HospitalsCreate,
    meta: {
      requiresAuth: true,
      role: [agentHospital]
    },
  },
  {
    path: "/acces-denied",
    name: "acces.denied",
    component: NotAcces,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/administrator",
    component: Administrator,
    children: [
      {
        path: 'users',
        component: AdminUserIndex
      },
      {
        path: 'users/create',
        component: AdminUserCreate,
      }
    ]
  },
  {
    path: "/landing",
    name: "landing",
    component: Landing,
    meta: {
      requiresAuth: true
    },
  }
];

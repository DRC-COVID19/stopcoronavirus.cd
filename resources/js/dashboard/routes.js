import Home from './pages/Home'
import Login from './pages/auth/Login'
import LostPassword from './pages/auth/LostPassword'
import ResetPasswordThank from './pages/auth/ResetPasswordThank'
import ResetPasseword from './pages/auth/ResetPassword'
import PasswordResetComplete from './pages/auth/PasswordResetComplete'
import HospitalsHome from './pages/hospital/Home'
import HospitalForm from './pages/hospital/HospitalForm'
import HospitalsDetail from './pages/hospital/HospitalDetail'
import HospitalData from './pages/hospital/HospitalData'
import HospitalAdmin from './pages/adminHospital/Home'
import HospitalAdminData from './pages/adminHospital/HospitalData'
import NotAcces from './pages/NotAccess'
import Landing from './pages/Landing'
import Administrator from './pages/Administrator'
import AdminUserIndex from './pages/administrator/users/Index'
import PageNotFound from './pages/NotFound'
import ChangeLogIndex from './pages/administrator/changeLog/index'
import Epidemie from './pages/administrator/epidemy/Index'
import FormIndex from './pages/administrator/forms/index'
import FormShow from './pages/administrator/forms/form'
import Main from './pages/Main'
import Dashboard from './pages/dashboard/Dashboard'
import {
  ADMIN_DASHBOARD,
  AGENT_HOSPITAL,
  ADMIN_HOSPITAL,
  ADMINISTRATOR,
  MANANGER_EPIDEMIC,
  EDIT_FORM,
  CREATE_FORM
} from './config/env'

export default [
  {
    name: 'login',
    path: '/login',
    component: Login
  },
  {
    name: 'lostPassword',
    path: '/lost-password',
    component: LostPassword
  },
  {
    name: 'password.reset.thanks',
    path: '/lost-password-send',
    component: ResetPasswordThank
  },
  {
    name: 'password.reset.token',
    path: '/password-reset/:token',
    component: ResetPasseword
  },
  {
    name: 'password.reset.complete.thanks',
    path: '/password-reset/complete',
    component: PasswordResetComplete
  },
  {
    path: '/',
    name: 'main',
    component: Main,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: 'dashboard',
        name: 'main.dashboard',
        component: Dashboard
      },
      {
        path: '*',
        redirect: { name: 'main.dashboard' }
      },
    ]
  },
  {
    path: '/dashboard/home',
    component: Home,
    name: 'home',
    meta: {
      requiresAuth: true,
      role: [ADMIN_DASHBOARD]
    }
  },
  {
    path: '/dashboard/infrastructure',
    component: Home,
    name: 'dashboard.infrastructure',
    meta: {
      requiresAuth: true,
      role: [ADMIN_DASHBOARD]
    }
  },
  {
    path: '/dashboard/a-propos',
    component: Home,
    name: 'dashboard.aPropos',
    meta: {
      requiresAuth: true,
      role: [ADMIN_DASHBOARD]
    }
  },
  {
    path: '/hospitals',
    name: 'hospital.home',
    component: HospitalsHome,
    meta: {
      requiresAuth: true,
      role: [AGENT_HOSPITAL]
    }
  },
  {
    path: '/admin/hospitals',
    name: 'hospital.admin',
    component: HospitalAdmin,
    meta: {
      requiresAuth: true,
      role: [ADMIN_HOSPITAL]
    }
  },
  {
    path: '/admin/hospitals/:hospital_id',
    name: 'hospital.admin.data',
    component: HospitalAdminData,
    meta: {
      requiresAuth: true,
      role: [ADMIN_HOSPITAL]
    }
  },
  {
    path: '/hospitals/data',
    name: 'hospital.data',
    component: HospitalData,
    meta: {
      requiresAuth: true,
      role: [AGENT_HOSPITAL]
    }
  },
  {
    path: '/hospitals/forms/:form_id',
    name: 'hospital.create',
    component: HospitalForm,
    meta: {
      requiresAuth: true,
      role: [AGENT_HOSPITAL]
    }
  },
  {
    path: '/hospitals/:hospital_id/show/:completed_form_id',
    name: 'hospital.detail',
    component: HospitalsDetail,
    meta: {
      requiresAuth: true,
      role: [AGENT_HOSPITAL, ADMIN_HOSPITAL]
    }
  },
  {
    path: '/hospital/:hospital_id/edit/:completed_form_id/form/:form_id',
    name: 'hospital.edit',
    component: HospitalForm,
    meta: {
      requiresAuth: true,
      role: [AGENT_HOSPITAL]
    }
  },
  {
    path: '/acces-denied',
    name: 'acces.denied',
    component: NotAcces,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/administrator',
    component: Administrator,
    name: 'administrator',
    meta: {
      requiresAuth: true,
      role: [ADMINISTRATOR]
    },
    children: [
      {
        path: '/',
        name: 'administrator.home',
        component: AdminUserIndex,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR]
        }
      },
      {
        path: 'users',
        name: 'administrator.users',
        component: AdminUserIndex,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR]
        }
      },
      {
        path: 'change-logs',
        component: ChangeLogIndex,
        name: 'administrator.changeLog',
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR]
        }
      },
      {
        path: 'forms',
        component: FormIndex,
        name: 'administrator.forms',
        meta: {
          requiresAuth: true,
          role: [CREATE_FORM] || [EDIT_FORM]
        }
      },
      {
        path: '/administrator/forms/:form_id',
        name: 'administrator.forms.show',
        component: FormShow,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
        }
      },
      {
        path: 'epidemie/',
        name: 'administrator.epidemie',
        component: Epidemie,
        meta: {
          requiresAuth: true,
          role: [MANANGER_EPIDEMIC]
        }
      }
    ]
  },
  {
    path: '/landing',
    name: 'landing',
    component: Landing,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: 'not_found',
    path: '*',
    component: PageNotFound
  }
]

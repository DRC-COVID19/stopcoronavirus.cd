import Home from './pages/Home'
import Login from './pages/auth/Login'
import LostPassword from './pages/auth/LostPassword'
import ResetPasswordThank from './pages/auth/ResetPasswordThank'
import ResetPasseword from './pages/auth/ResetPassword'
import PasswordResetComplete from './pages/auth/PasswordResetComplete'
import HospitalsHome from './pages/hospital/Home'
import HospitalNotification from './pages/hospital/Notification'
import HospitalForm from './pages/hospital/HospitalForm'
import BugTracker from './pages/bug_tracker/Index'
import HospitalsDetail from './pages/hospital/HospitalDetail'
import HospitalData from './pages/hospital/HospitalData'
import HospitalAdmin from './pages/adminHospital/Home'
import HospitalAdminData from './pages/adminHospital/HospitalData'
import NotAcces from './pages/NotAccess'
import Administrator from './pages/administrator/Administrator'
import AdminUserIndex from './pages/administrator/users/Index'
import AdminHospitalIndex from './pages/administrator/hospitals/Index'
import PageNotFound from './pages/NotFound'
import ChangeLogIndex from './pages/administrator/changeLog/index'
import Epidemie from './pages/administrator/epidemy/Index'
import FormIndex from './pages/administrator/forms2/index'
import FormShow from './pages/administrator/forms/form'
import FormShow2 from './pages/administrator/forms2/formDetail/index'
import FormCreation from './pages/administrator/forms2/formDetail/formCreation'
import FormFieldIndex from './pages/administrator/forms2/formDetail/components/formField/FormFieldIndex'

import FormSettings from './pages/administrator/forms2/formDetail/formSettings'
import FormSchemas from './pages/administrator/forms2/formDetail/formSchemas'
import FormResponse from './pages/administrator/forms2/formDetail/formResponse'
import FormPreview from './pages/administrator/forms2/formDetail/formPreview'
import Main from './pages/Main'
import Dashboard from './pages/dashboard/Dashboard'
import Chart from './pages/dashboard/chart/HomeChart'
import CTCO from './pages/ctco/CTCO'
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
      /**
       * Dashboard routes
       */
      {
        path: 'dashboard',
        name: 'main.dashboard',
        component: Dashboard,
        children: [
          {
            path: 'mobility',
            component: Home,
            name: 'main.dashboard.mobility',
            meta: {
              requiresAuth: true,
              role: [ADMIN_DASHBOARD]
            }
          },
          {
            path: 'infrastructure',
            component: Home,
            name: 'main.dashboard.infrastructure',
            meta: {
              requiresAuth: true,
              role: [ADMIN_DASHBOARD]
            }
          },
          {
            path: 'graphique',
            component: Chart,
            name: 'main.dashboard.graphique',
            meta: {
              requiresAuth: true,
              role: [ADMIN_DASHBOARD]
            }
          },
          {
            path: 'a-propos',
            component: Home,
            name: 'main.dashboard.aPropos',
            meta: {
              requiresAuth: true,
              role: [ADMIN_DASHBOARD]
            }
          },
          {
            path: '*',
            redirect: { name: 'main.dashboard.mobility' }
          }
        ]
      },

      /**
       * Administration routes
       */
      {
        path: '/administration',
        component: Administrator,
        name: 'administrator',
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM, MANANGER_EPIDEMIC]
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
            path: 'hospitals',
            name: 'administrator.hospitals',
            component: AdminHospitalIndex,
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
              role: [CREATE_FORM, EDIT_FORM]
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
      /**
       * CTCO routes
       */
      {
        path: '/hospitals',
        name: 'hospitals',
        component: CTCO,
        meta: {
          requiresAuth: true,
          role: [AGENT_HOSPITAL, ADMIN_HOSPITAL]
        },
        children: [
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
            path: '/notifications',
            name: 'hospital.notification',
            component: HospitalNotification,
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
          }
        ]
      },

      /**
       * Bug tracker route routes
       */
      {
        path: '/bug_tracker',
        name: 'bug_tracker',
        component: BugTracker,
        meta: {
          requiresAuth: false,
          role: [
            AGENT_HOSPITAL,
            ADMIN_HOSPITAL,
            ADMINISTRATOR,
            CREATE_FORM,
            EDIT_FORM,
            MANANGER_EPIDEMIC
          ]
        }
      }
    ]
  },
  /**
   * FormDetail routes
   */
  {
    path: '/administration/forms/:form_id',
    name: 'administrator.forms.show',
    component: FormShow2,
    meta: {
      requiresAuth: true,
      role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
    },
    children: [
      {
        path: '/',
        name: 'administrator.forms.show.creation',
        component: FormCreation,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
        },
        children: [
          {
            path: '/administration/forms/:form_id/step/:step_id',
            name: 'administrator.forms.show.creation.step',
            component: FormFieldIndex,
            meta: {
              requiresAuth: true,
              role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
            }
          }
        ]
      },
      {
        path: '/administration/forms/:form_id/response',
        name: 'administrator.forms.show.response',
        component: FormResponse,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
        }
      },
      {
        path: '/administration/forms/:form_id/schema',
        name: 'administrator.forms.show.schema',
        component: FormSchemas,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
        }
      },
      {
        path: '/administration/forms/:form_id/setting',
        name: 'administrator.forms.show.setting',
        component: FormSettings,
        meta: {
          requiresAuth: true,
          role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
        }
      }
    ]
  },
  {
    path: '/administration/forms/:form_id/form-preview',
    name: 'administrator.forms.show.form-preview',
    component: FormPreview,
    meta: {
      requiresAuth: true,
      role: [ADMINISTRATOR, CREATE_FORM, EDIT_FORM]
    }
  },
  {
    path: '/acces-denied',
    name: 'acces.denied',
    component: NotAcces
  }
]

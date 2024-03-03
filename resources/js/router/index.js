import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

/* Login/Register Component */
const Login = () => import('@/components/auth/Login.vue')
const Register = () => import('@/components/auth/Register.vue')

/* Layouts */
const DahboardLayout = () => import('@/components/layouts/Default.vue')

/* Authenticated Component */
const Dashboard = () => import('@/components/admin/Dashboard.vue')
const Deposit = () => import('@/components/admin/deposit/Deposit.vue')
const Withdraw = () => import('@/components/admin/withdraw/Withdraw.vue')
const Transfer = () => import('@/components/admin/transfer/Transfer.vue')
const Statement = () => import('@/components/admin/statement/List.vue')

/* Guest Component */
const Home = () => import('@/components/customer/Home.vue')

const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/dashboard",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/dashboard',
                component: Dashboard,
                meta: {
                    title: `Dashboard`
                }
            },
            {
              name: "deposit",
              path: '/deposit',
              component: Deposit,
              meta: {
                  title: `Deposit`
              }
            },
            {
              name: "withdraw",
              path: '/withdraw',
              component: Withdraw,
              meta: {
                  title: `Withdraw`
              }
            },
            {
              name: "transfer",
              path: '/transfer',
              component: Transfer,
              meta: {
                  title: `Transfer`
              }
            },
            {
              name: "statement",
              path: '/statement',
              component: Statement,
              meta: {
                  title: `Statement`
              }
            }
        ]
    },
    {
      path: "/",
      component: DahboardLayout,
      meta: {
          middleware: "guest"
      },
      children: [
          {
              name: "home",
              path: '/',
              component: Home,
              meta: {
                  title: `Home`
              }
          }
      ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export default router
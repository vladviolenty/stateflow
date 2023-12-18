import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'bootstrap/scss/bootstrap.scss'
import 'bootstrap-icons/font/bootstrap-icons.scss'
import App from './App.vue'

import {createRouter, createWebHashHistory} from "vue-router";

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            redirect: '/dashboard'
        },
        {
            path: '/register',
            component: () => import('./components/Auth/RegisterPage.vue')
        },
        {
            path: '/auth',
            component: () =>  import('./components/Auth/AuthPage.vue')
        },
        {
            path: '/dashboard',
            component: () => import("./components/Dashboard.vue"),
            children:[
                {
                    path:"",
                    component:() => import('./components/Dashboard/Home.vue')
                },
                {
                    path:"profile",
                    component:() => import('./components/EmptyRouterView.vue'),
                    children:[
                        {
                            path:"",
                            component:() => import('./components/Dashboard/Profile.vue')
                        },
                        {
                            path:"email",
                            component:() => import('./components/Dashboard/Profile/EmailConfigure.vue')
                        },
                        {
                            path:"phones",
                            component:() => import('./components/Dashboard/Profile/PhonesConfigure.vue')
                        },
                        {
                            path:"sessions",
                            component:() => import('./components/Dashboard/Profile/SessionConfigure.vue')
                        }
                    ]
                },
                {
                    path:"workflow",
                    component:() => import('./components/EmptyRouterView.vue'),
                    children:[
                        {
                            path:"",
                            component:() => import('./components/Workflow/OrgList.vue.vue')
                        },
                    ]
                },
                {
                    path:"services",
                    component:() => import('./components/Dashboard/Services.vue')
                },
            ],
        }
    ]
})

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')

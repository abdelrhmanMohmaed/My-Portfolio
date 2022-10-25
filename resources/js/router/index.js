import {
    createRouter,
    createWebHistory
} from "vue-router";

//Admin
import homeAdminIndex from '../components/admin/home/index.vue';
import adminAboutIndex from '../components/admin/about/index.vue';
import adminServiceIndex from '../components/admin/services/index.vue';
import adminSkillIndex from '../components/admin/skills/index.vue';
import adminEducationIndex from '../components/admin/educations/index.vue';
import adminExperienceIndex from '../components/admin/experiences/index.vue';
import adminProjectIndex from '../components/admin/projects/index.vue';
import adminNewProjectIndex from '../components/admin/projects/new.vue';
import adminEditProjectIndex from '../components/admin/projects/edit.vue';

//Pages
import homePageIndex from '../components/pages/home/index.vue';

// login
import login from '../components/auth/login.vue';

//Not Found Page
import notFound from '../components/notFound.vue';




const routes = [
    //Admin
    {
        path: '/admin/home',
        name: 'AdminHome',
        component: homeAdminIndex,
        meta: {
            requestAuth: true,
        }
    },
    //about
    {
        path: '/admin/about',
        name: 'AdminAbout',
        component: adminAboutIndex,
        meta: {
            requestAuth: true,
        }
    },
    //services
    {
        path: '/admin/services',
        name: 'AdminServices',
        component: adminServiceIndex,
        meta: {
            requestAuth: true,
        }
    },
    //skills
    {
        path: '/admin/skills',
        name: 'AdminSkills',
        component: adminSkillIndex,
        meta: {
            requestAuth: true,
        }
    },
    //educations
    {
        path: '/admin/educations',
        name: 'AdminEducations',
        component: adminEducationIndex,
        meta: {
            requestAuth: true,
        }
    },
    // experiences
    {
        path: '/admin/experiences',
        name: 'AdminExperiences',
        component: adminExperienceIndex,
        meta: {
            requestAuth: true,
        }
    },
    // projects
    {
        path: '/admin/projects',
        name: 'AdminProjects',
        component: adminProjectIndex,
        meta: {
            requestAuth: true,
        }
    },
    // projectsNew
    {
        path: '/admin/new/project',
        name: 'AdminNewProjects',
        component: adminNewProjectIndex,
        meta: {
            requestAuth: true,
        }
    },
    // projectsEdit
    {
        path: '/admin/edit/project/:id',
        name: 'AdminEditProjects',
        component: adminEditProjectIndex,
        meta: {
            requestAuth: true,
        },
        props: true,
    },
    //Pages
    {
        path: '/',
        name: 'Home',
        component: homePageIndex,
        meta: {
            requestAuth: false,
        }
    },
    // auth
    {
        path: '/login',
        name: 'Login',
        component: login,
        meta: {
            requestAuth: false,
        }
    },
    //notFound
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: notFound,
        meta: {
            requestAuth: false,
        }
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    if (to.meta.requestAuth && !localStorage.getItem('token')) {
        return {
            name: 'Login'
        }
    }
    if (to.meta.requestAuth == false && localStorage.getItem('token')) {
        return {
            name: 'AdminHome'
        }
    }
});

export default router

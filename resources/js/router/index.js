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
import adminCreateProjectIndex from '../components/admin/projects/create.vue';
import adminEditProjectIndex from '../components/admin/projects/edit.vue';
import adminTestimonialIndex from '../components/admin/testimonial/index.vue';
import adminCreateTestimonial from '../components/admin/testimonial/create.vue';
import adminEditTestimonial from '../components/admin/testimonial/edit.vue';
import adminMessageIndex from '../components/admin/messages/index.vue';
import adminUsersIndex from '../components/admin/users/index.vue';




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
    //experiences
    {
        path: '/admin/experiences',
        name: 'AdminExperiences',
        component: adminExperienceIndex,
        meta: {
            requestAuth: true,
        }
    },
    //projects
    {
        path: '/admin/projects',
        name: 'AdminProjects',
        component: adminProjectIndex,
        meta: {
            requestAuth: true,
        }
    },
    //Create project
    {
        path: '/admin/create/project',
        name: 'AdminCreateProjects',
        component: adminCreateProjectIndex,
        meta: {
            requestAuth: true,
        }
    },
    //projectsEdit
    {
        path: '/admin/edit/project/:id',
        name: 'AdminEditProjects',
        component: adminEditProjectIndex,
        meta: {
            requestAuth: true,
        },
        props: true,
    },
    //testimonials
    {
        path: '/admin/testimonials',
        name: 'AdminTestimonial',
        component: adminTestimonialIndex,
        meta: {
            requestAuth: true,
        }
    },
    //testimonialsNew
    {
        path: '/admin/create/testimonial',
        name: 'AdminCreateTestimonials',
        component: adminCreateTestimonial,
        meta: {
            requestAuth: true,
        }
    },
    //testimonialsEdit
    {
        path: '/admin/edit/testimonial/:id',
        name: 'AdminEditTestimonials',
        component: adminEditTestimonial,
        meta: {
            requestAuth: true,
        },
        props: true,
    },
    //message
    {
        path: '/admin/messages',
        name: 'AdminMessages',
        component: adminMessageIndex,
        meta: {
            requestAuth: true,
        }
    },
    //users
    {
        path: '/admin/users',
        name: 'AdminUsers',
        component: adminUsersIndex,
        meta: {
            requestAuth: true,
        }
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

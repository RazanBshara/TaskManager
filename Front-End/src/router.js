import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      redirect: "/workspace",
      component: () => import("@/view/layout/Layout"),
      children: [
        {
          path: "/myrequests",
          name: "myrequests",
          component: () => import("@/view/pages/MyRequests.vue"),
        },
        // {
        //   path: "/builder",
        //   name: "builder",
        //   component: () => import("@/view/pages/Builder.vue"),
        // },
        {
          path: "/workspace",
          name: "workspace",
          component: () => import("@/view/pages/Workspace.vue"),
        },
        {
          path: "/editworkspace",
          name: "editworkspace",
          component: () => import("@/view/pages/EditWorkspace.vue"),
        },
        {
          path: "/addworkspace",
          name: "addworkspace",
          component: () => import("@/view/pages/AddWorkspace.vue"),
        },
        {
          path: "/projects",
          name: "projects",
          component: () => import("@/view/pages/Projects.vue"),
        },
        {
          path: "/editprojects",
          name: "editprojects",
          component: () => import("@/view/pages/EditProjects.vue"),
        },
        {
          path: "/addproject",
          name: "addproject",
          component: () => import("@/view/pages/AddProject.vue"),
        },
        {
          path: "/tasks",
          name: "tasks",
          component: () => import("@/view/pages/Tasks.vue"),
        },
        {
          path: "/addtask",
          name: "addtask",
          component: () => import("@/view/pages/AddTask.vue"),
        },
        {
          path: "/showtasks",
          name: "showtasks",
          component: () => import("@/view/pages/ShowTasks.vue"),
        },
        {
          path: "/edittasks",
          name: "edittasks",
          component: () => import("@/view/pages/EditTasks.vue"),
        },
        // {
        //   path: "/workflow",
        //   name: "workflow",
        //   component: () => import("@/view/pages/Workflow.vue"),
        // },
        {
          path: "/job",
          name: "job",
          component: () => import("@/view/pages/Job.vue"),
        },
        {
          path: "/addjob",
          name: "addjob",
          component: () => import("@/view/pages/Addjob.vue"),
        },
        {
          path: "/invitation",
          name: "invitation",
          component: () => import("@/view/pages/Invitation.vue"),
        },
        {
          path: "/addinvitation",
          name: "addinvitation",
          component: () => import("@/view/pages/Addinvitation.vue"),
        },
        {
          path: "/rolegroup",
          name: "rolegroup",
          component: () => import("@/view/pages/Rolegroup.vue"),
        },
        {
          path: "/addrolegroup",
          name: "addrolegroup",
          component: () => import("@/view/pages/Addrolegroup.vue"),
        },
        {
          path: "/rolegroupcompany",
          name: "rolegroupcompany",
          component: () => import("@/view/pages/Rolegroupcompany.vue"),
        },
        {
          path: "/addrolegroupcompany",
          name: "addrolegroupcompany",
          component: () => import("@/view/pages/Addrolegroupcompany.vue"),
        },
        {
          path: "/calendar",
          name: "calendar",
          component: () => import("@/view/pages/Calendar.vue"),
        },
        {
          path: "/userprofile",
          name: "userprofile",
          component: () => import("@/view/pages/UserProfile.vue"),
        },
        {
          path: "/dropdownnotification",
          name: " dropdownnotification",
          component: () =>
            import("@/view/layout/extras/dropdown/DropdownNotification.vue"),
        },

        // {
        //   path: "/people",
        //   name: "people",
        //   component: () => import("@/view/pages/People.vue"),
        // },
        {
          path: "/unit",
          name: "unit",
          component: () => import("@/view/pages/Unit.vue"),
        },
        {
          path: "/widget8",
          name: "widget8",
          component: () => import("@/view/content/widgets/list/Widget8.vue"),
        },
        {
          path: "/createunit",
          name: "createunit",
          component: () => import("@/view/pages/CreateUnit.vue"),
        },

        {
          path: "/vue-bootstrap",
          name: "vue-bootstrap",
          component: () =>
            import("@/view/pages/vue-bootstrap/VueBootstrap.vue"),
          children: [
            {
              path: "alert",
              name: "vue-bootstrap-alert",
              component: () => import("@/view/pages/vue-bootstrap/Alert.vue"),
            },
            {
              path: "badge",
              name: "vue-bootstrap-badge",
              component: () => import("@/view/pages/vue-bootstrap/Badge.vue"),
            },
            {
              path: "button",
              name: "vue-bootstrap-button",
              component: () => import("@/view/pages/vue-bootstrap/Button.vue"),
            },
            {
              path: "button-group",
              name: "vue-bootstrap-button-group",
              component: () =>
                import("@/view/pages/vue-bootstrap/ButtonGroup.vue"),
            },
            {
              path: "button-toolbar",
              name: "vue-bootstrap-button-toolbar",
              component: () =>
                import("@/view/pages/vue-bootstrap/ButtonToolbar.vue"),
            },
            {
              path: "card",
              name: "vue-bootstrap-card",
              component: () => import("@/view/pages/vue-bootstrap/Card.vue"),
            },
            {
              path: "carousel",
              name: "vue-bootstrap-carousel",
              component: () =>
                import("@/view/pages/vue-bootstrap/Carousel.vue"),
            },
            {
              path: "collapse",
              name: "vue-bootstrap-collapse",
              component: () =>
                import("@/view/pages/vue-bootstrap/Collapse.vue"),
            },
            {
              path: "dropdown",
              name: "vue-bootstrap-dropdown",
              component: () =>
                import("@/view/pages/vue-bootstrap/Dropdown.vue"),
            },
            {
              path: "embed",
              name: "vue-bootstrap-embed",
              component: () => import("@/view/pages/vue-bootstrap/Embed.vue"),
            },
            {
              path: "form",
              name: "vue-bootstrap-form",
              component: () => import("@/view/pages/vue-bootstrap/Form.vue"),
            },
            {
              path: "form-checkbox",
              name: "vue-bootstrap-form-checkbox",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormCheckbox.vue"),
            },
            {
              path: "form-file",
              name: "vue-bootstrap-form-file",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormFile.vue"),
            },
            {
              path: "form-group",
              name: "vue-bootstrap-form-group",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormGroup.vue"),
            },
            {
              path: "form-input",
              name: "vue-bootstrap-form-input",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormInput.vue"),
            },
            {
              path: "form-radio",
              name: "vue-bootstrap-form-radio",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormRadio.vue"),
            },
            {
              path: "form-select",
              name: "vue-bootstrap-form-select",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormSelect.vue"),
            },
            {
              path: "form-textarea",
              name: "vue-bootstrap-form-textarea",
              component: () =>
                import("@/view/pages/vue-bootstrap/FormTextarea.vue"),
            },
            {
              path: "image",
              name: "vue-bootstrap-image",
              component: () => import("@/view/pages/vue-bootstrap/Image.vue"),
            },
            {
              path: "input-group",
              name: "vue-bootstrap-input-group",
              component: () =>
                import("@/view/pages/vue-bootstrap/InputGroup.vue"),
            },
            {
              path: "jumbotron",
              name: "vue-bootstrap-jumbotron",
              component: () =>
                import("@/view/pages/vue-bootstrap/Jumbotron.vue"),
            },
            {
              path: "layout-grid-system",
              name: "vue-bootstrap-layout-grid-system",
              component: () =>
                import("@/view/pages/vue-bootstrap/LayoutGridSystem.vue"),
            },
            {
              path: "link",
              name: "vue-bootstrap-link",
              component: () => import("@/view/pages/vue-bootstrap/Link.vue"),
            },
            {
              path: "list-group",
              name: "vue-bootstrap-list-group",
              component: () =>
                import("@/view/pages/vue-bootstrap/ListGroup.vue"),
            },
            {
              path: "media",
              name: "vue-bootstrap-media",
              component: () => import("@/view/pages/vue-bootstrap/Media.vue"),
            },
            {
              path: "modal",
              name: "vue-bootstrap-modal",
              component: () => import("@/view/pages/vue-bootstrap/Modal.vue"),
            },
            {
              path: "nav",
              name: "vue-bootstrap-nav",
              component: () => import("@/view/pages/vue-bootstrap/Nav.vue"),
            },
            {
              path: "navbar",
              name: "vue-bootstrap-navbar",
              component: () => import("@/view/pages/vue-bootstrap/Navbar.vue"),
            },
            {
              path: "pagination",
              name: "vue-bootstrap-pagination",
              component: () =>
                import("@/view/pages/vue-bootstrap/Pagination.vue"),
            },
            {
              path: "pagination-nav",
              name: "vue-bootstrap-pagination-nav",
              component: () =>
                import("@/view/pages/vue-bootstrap/PaginationNav.vue"),
            },
            {
              path: "popover",
              name: "vue-bootstrap-popover",
              component: () => import("@/view/pages/vue-bootstrap/Popover.vue"),
            },
            {
              path: "progress",
              name: "vue-bootstrap-progress",
              component: () =>
                import("@/view/pages/vue-bootstrap/Progress.vue"),
            },
            {
              path: "spinner",
              name: "vue-bootstrap-spinner",
              component: () => import("@/view/pages/vue-bootstrap/Spinner.vue"),
            },
            {
              path: "table",
              name: "vue-bootstrap-table",
              component: () => import("@/view/pages/vue-bootstrap/Table.vue"),
            },
            {
              path: "tabs",
              name: "vue-bootstrap-tabs",
              component: () => import("@/view/pages/vue-bootstrap/Tabs.vue"),
            },
            {
              path: "toasts",
              name: "vue-bootstrap-toasts",
              component: () => import("@/view/pages/vue-bootstrap/Toasts.vue"),
            },
            {
              path: "tooltip",
              name: "vue-bootstrap-tooltip",
              component: () => import("@/view/pages/vue-bootstrap/Tooltip.vue"),
            },
          ],
        },
        {
          path: "/wizard",
          name: "wizard",
          component: () => import("@/view/pages/wizard/Wizard.vue"),
          children: [
            {
              path: "wizard-1",
              name: "wizard-1",
              component: () => import("@/view/pages/wizard/Wizard-1.vue"),
            },
            {
              path: "wizard-2",
              name: "wizard-2",
              component: () => import("@/view/pages/wizard/Wizard-2.vue"),
            },
            {
              path: "wizard-3",
              name: "wizard-3",
              component: () => import("@/view/pages/wizard/Wizard-3.vue"),
            },
            {
              path: "wizard-4",
              name: "wizard-4",
              component: () => import("@/view/pages/wizard/Wizard-4.vue"),
            },
          ],
        },
      ],
    },
    {
      path: "/error",
      name: "error",
      component: () => import("@/view/pages/error/Error.vue"),
      children: [
        {
          path: "error-1",
          name: "error-1",
          component: () => import("@/view/pages/error/Error-1.vue"),
        },
        {
          path: "error-2",
          name: "error-2",
          component: () => import("@/view/pages/error/Error-2.vue"),
        },
        {
          path: "error-3",
          name: "error-3",
          component: () => import("@/view/pages/error/Error-3.vue"),
        },
        {
          path: "error-4",
          name: "error-4",
          component: () => import("@/view/pages/error/Error-4.vue"),
        },
        {
          path: "error-5",
          name: "error-5",
          component: () => import("@/view/pages/error/Error-5.vue"),
        },
        {
          path: "error-6",
          name: "error-6",
          component: () => import("@/view/pages/error/Error-6.vue"),
        },
      ],
    },
    {
      path: "/",
      component: () => import("@/view/pages/auth/Auth"),
      children: [
        {
          name: "login",
          path: "/login",
          component: () => import("@/view/pages/auth/Login"),
        },
        {
          name: "forgetpassword",
          path: "/forgetpassword",
          component: () => import("@/view/pages/auth/ForgetPassword"),
        },
        {
          name: "register",
          path: "/register",
          component: () => import("@/view/pages/auth/Register"),
        },
        {
          name: "company",
          path: "/company",
          component: () => import("@/view/pages/auth/Company"),
        },
        {
          name: "joincompany",
          path: "/joincompany",
          component: () => import("@/view/pages/auth/JoinCompany"),
        },
      ],
    },
    // {
    //   path: "/calendar",
    //   name: "calendar",
    //   component: () => import("@/view/pages/body/Calendar.vue"),
    // },
    {
      path: "*",
      redirect: "/404",
    },
    {
      // the 404 route, when none of the above matches
      path: "/404",
      name: "404",
      component: () => import("@/view/pages/error/Error-1.vue"),
    },
  ],
});

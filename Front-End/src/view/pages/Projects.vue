<template>
  <div class="mt-1">
    <!--YYY begin header-->
    <div>
      <b-nav class="mx-1">
        <b-item class="font-size-h1 font-weight-weight">Projects</b-item>
        <!-- <b-nav-item>Complete Projects</b-nav-item> -->
      </b-nav>
    </div>
    <!--YYYYYYYYY begin add project-->
    <div class="row">
      <div class="col-md-8 text-left left-0">
        <b-button
          v-b-modal.modal-center
          @click="modalShow = !modalShow"
          v-b-modal.modal-prevent-closing
          pill
          variant="primary"
          class="col-xl-3 py-1 mx-0 mt-10 font-size-h5"
          >+ Add Your Project</b-button
        >
        <b-modal
          v-model="modalShow"
          id="modal-prevent-closing"
          ref="modal"
          centered
          title="Add Project"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleOk"
          hide-footer="true"
        >
          <form ref="form" @submit.stop.prevent="handleSubmit">
            <h4 class="mb-10 font-weight-bold text-dark">
              Enter your Project Details
            </h4>
            <!--YYYYYYYYYYYY Project name-->
            <b-form-group
              label="Project Name*"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-input
                id="name-input"
                v-model="project.name"
                :state="nameState"
                placeholder="Enter Name"
                class="form-control form-control-solid form-control-lg"
                required
              ></b-form-input>
            </b-form-group>
            <!--YYYYYYYYYYYY Project description-->

            <b-form-group
              label="Description"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-textarea
                id="textarea-rows"
                v-model="project.description"
                :state="nameState"
                placeholder="Describe Your Project..."
                class="form-control form-control-solid form-control-lg"
                rows="6"
              ></b-form-textarea>
            </b-form-group>
            <!--YYYYYYYYYYYYYYYYYYY Via multiple directive modifiers -->
            <div>
              <b-nav class="mx-0 mr-5 pr-5 col-md-6 py-1">
                <b-nav-item v-b-toggle="'collapse-a collapse-b'"
                  >show more options</b-nav-item
                >
              </b-nav>
            </div>
            <!-- Elements to collapse -->
            <div class="mx-0 mr-4">
              <b-collapse id="collapse-a" class="mt-2">
                <!--YYYYYYYYYYYYYYY start date-->

                <div class="col-xl-6">
                  <div class="form-group">
                    <label
                      class="font-weight-bold text-dark"
                      for="datepicker-buttons"
                      >Start Date</label
                    >
                    <b-form-datepicker
                      id="datepicker-buttons"
                      v-model="project.startdate"
                      today-button
                      reset-button
                      close-button
                      locale="en"
                      class="mb-2"
                      required
                    ></b-form-datepicker>
                  </div>
                </div>
                <!--YYYYYYYYYYYYYYY end date-->
                <div class="col-xl-6">
                  <div class="form-group">
                    <label class="font-weight-bold text-dark">End Date*</label>
                    <b-form-datepicker
                      id="example-datepicker"
                      v-model="project.enddate"
                      class="mb-2"
                    ></b-form-datepicker>
                  </div>
                </div>
                <!-- <div class="col-xl-6">
                    <div class="form-group">
                      <label
                        class="font-weight-bold text-dark"
                        for="datepicker-buttons"
                        >End Date</label
                      >
                      <b-form-datepicker
                        id="datepicker-buttons"
                        v-model="project.enddate"
                        today-button
                        reset-button
                        close-button
                        locale="en"
                        class="mb-2"
                      ></b-form-datepicker>
                    </div>
                  </div> -->

                <!--YYYYYYYYYYYYYYY label-->

                <b-item class="p-5 font-weight-bold ">Label</b-item>
                <b-nav class="mx-1 mt-2">
                  <b-dropdown
                    split
                    split-variant="outline-primary"
                    variant="primary"
                    text="Choose a label..."
                    class="mr-5 pr-5 col-xl-6"
                  >
                    <b-form-group
                      label=""
                      v-slot="{ ariaDescribedby }"
                      class="m-5"
                    >
                      <b-form-radio
                        v-model="project.label"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="No label.."
                        >No label..</b-form-radio
                      >
                      <b-form-radio
                        v-model="project.label"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="Canceled"
                        >Canceled</b-form-radio
                      >
                      <b-form-radio
                        v-model="project.label"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="In Progress"
                        >In Progress</b-form-radio
                      >
                      <b-form-radio
                        v-model="project.label"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="New"
                        >New</b-form-radio
                      >
                      <b-form-radio
                        v-model="project.label"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="Paused"
                        >Paused</b-form-radio
                      >
                    </b-form-group>
                  </b-dropdown>
                </b-nav>

                <br />
                <br />
                <!--YYYYYYYYYYYYYYY Category-->
                <!-- <b-item class="p-5 font-weight-bold">Category</b-item>
                <b-nav class="mx-1 mt-2">
                  <b-dropdown
                    split
                    split-variant="outline-primary"
                    variant="primary"
                    text="Choose a category..."
                    class="mr-5 pr-5 col-xl-7"
                  >
                    <b-form-group class="m-5" v-slot="{ ariaDescribedby }">
                      <b-form-radio
                        v-model="selected"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        value="A"
                        >No Category..</b-form-radio
                      >
                    </b-form-group>
                  </b-dropdown>
                </b-nav> -->

                <!-- <b-item class="font-weight-bold">Time Tracking</b-item>
                      <b-form-checkbox switch size="md" class="mt-4"
                        >Enable time tracking</b-form-checkbox
                      >
                      <b-form-checkbox switch size="md"
                        >Allow clients to see time records</b-form-checkbox
                      > -->

                <!-- <div class="form-group">
                        <label>Job types</label>
                        <select
                          name="country"
                          class="form-control form-control-md"
                        >
                          <option value="">Select</option>
                        </select>
                      </div> -->
              </b-collapse>
            </div>
            <!-- <span>{{project}}</span> -->
            <!--YYYYYYYYYYYY Project buttons-->
            <div class="d-flex justify-content-between border-top pt-8">
              <div class="mr-2">
                <button
                  @click="onSubmitAddProject"
                  class="btn btn-light-primary font-weight-bold text-uppercase px-6 py-2"
                  data-wizard-type="action-prev"
                >
                  Create Project
                </button>
              </div>
              <div>
                <button
                  v-on:click="$router.push('projects')"
                  class="btn btn-success font-weight-bold text-uppercase px-6 py-2"
                  size="sm"
                  data-wizard-type="action-submit"
                >
                  Cancel
                </button>
              </div>
            </div>
          </form>
        </b-modal>
      </div>
    </div>

    <div class="mt-10 mb-4"></div>

    <!--YYYYYYYYYY begin card 1-->
    <div class="col-md-6">
      <b-card-group deck>
        <!--YYYYYYYYYYYY begin card 3-->
        <b-card
          bg-variant="light"
          header-tag="header"
          title=""
          footer-tag="footer"
          style="max-width: 20rem;"
          v-for="projects in projectsGeted"
          :key="projects.name"
          :value="projects.name"
        >
          <b-card-text
            ><strong>Project Manager: {{ projects.ProjectManager }}</strong>
          </b-card-text>
          <b-card-text>Start Date : {{ projects.startdate }}</b-card-text>
          <b-card-text>End Date : {{ projects.enddate }}</b-card-text>
          <b-card-text>Description : {{ projects.description }}</b-card-text>

          <template #header>
            <div class="mt-0 ma-4" style="height: 36px">
              <h6 class="mb-0">{{ projects.name }}</h6>

              <!-- <b-icon
                class="pl-23 mx-40 mt-0 py-0 ma-5"
                icon="star-fill"
                variant="warning"
              ></b-icon> -->
              <div class="card-toolbar pl-20 mx-40">
                <!-- <Dropdown2></Dropdown2> -->
              </div>
            </div>
            <td class="text-right pr-0">
              <a
                href="#"
                v-on:click="showtasks(projects.id)"
                class="btn btn-icon btn-light btn-sm"
              >
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon-->
                  <inline-svg
                    src="media/svg/icons/General/Settings-1.svg"
                  ></inline-svg>
                  <!--end::Svg Icon-->
                </span>
              </a>
              <a
                href="#"
                v-on:click="editProject(projects.id)"
                class="btn btn-icon btn-light btn-sm mx-1"
              >
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon-->
                  <inline-svg
                    src="media/svg/icons/Communication/Write.svg"
                  ></inline-svg>
                  <!--end::Svg Icon-->
                </span>
              </a>
              <a
                href="#"
                class="btn btn-icon btn-light btn-sm"
                v-on:click="deleteProject(projects.id)"
              >
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon-->
                  <inline-svg
                    src="media/svg/icons/General/Trash.svg"
                  ></inline-svg>
                  <!--end::Svg Icon-->
                </span>
              </a>
            </td>
          </template>
          <!-- <span>{{ projectsGeted }}}</span> -->
          <!-- <b-card-text>This is a sample project of "Architecture"</b-card-text> -->
          <!-- <template #footer>
            <em class="text-muted">Active 1 month ago</em>
          </template> -->
        </b-card>
      </b-card-group>
    </div>
    <!-- <span>{{ projectsGeted }}</span> -->
  </div>
</template>
<script>
// import Dropdown2 from "@/view/content/dropdown/Dropdown2.vue";
import axios from "axios";
import router from "@/router.js";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      workspaceid: localStorage.getItem("workspaceid"),
      projectManagersGeted: "",
      projectsGeted: "",
      project: {
        modalShow: false,
        name: "",
        description: "",
        startdate: "",
        enddate: "",
        workspaceid: localStorage.getItem("workspaceid"),
        label: "",
        nameState: null,
      },
      selected: null, // Must be an array reference!
      options: [
        { text: "InProgress", value: "no label" },
        { text: "InProgress", value: "inprogress" },
        { text: "Canceled", value: "canceled" },
        { text: "New", value: "new" },
        { text: "Paused", value: "paused" },
      ],
      show: true,
      parenttask: "",
      select: null,
    };
  },
  // created: function() {
  //   axios
  //     .get("http://127.0.0.1:8000/api/project/", {
  //       // params:{

  //       // },
  //       headers: {
  //         Accept: "application/json",
  //       },
  //     })
  //     .then((response) => {
  //       this.unit = response.data.data;
  //     });
  // },
  methods: {
    showtasks(projectid) {
      axios({
        method: "get",
        url: `http://127.0.0.1:8000/api/project/${projectid}`,
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
        if (
          response.status === 201 ||
          response.status === 204 ||
          response.status === 200
        ) {
          localStorage.setItem("projectid", projectid);
          console.log(JSON.stringify(response.data)),
            router.replace("/tasks");
        }
      });
    },
    deleteProject(projectid) {
      axios({
        method: "delete",
        url: `http://127.0.0.1:8000/api/project/${projectid}`,
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      });
    },
    editProject(id) {
      localStorage.setItem("projectid", id);
      router.replace("/editprojects");
    },
    onSubmitAddProject() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/project",
        data: {
          name: this.project.name,
          description: this.project.description,
          startdate: this.project.startdate,
          enddate: this.project.enddate,
          label: this.project.label,
          workspaceid: this.project.workspaceid,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
        if (response.status == 201) {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-prevent-closing");
          });
          // console.log(JSON.stringify(response.data)),
          //   router.replace("/workspace");
        }
      });
    },
  },
  computed: {
    ...mapGetters(["layoutConfig"]),
    state() {
      return Boolean(this.value);
    },
  },
  created: function() {
    axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/projectindex/${this.workspaceid}`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.projectsGeted = response.data;
    });
  },
};
</script>

<template>
  <div class="mt-1">
    <!--YYY begin header-->
    <div>
      <b-nav class="mx-1">
        <b-item class="font-size-h1 font-weight-weight">Tasks</b-item>
        <!-- <b-nav-item>Complete Projects</b-nav-item> -->
      </b-nav>
    </div>
    <!-- begin button Add Task-->
    <div class="row">
      <div class="col-md-8 text-left left-0">
        <b-button
          v-b-modal.modal-center
          @click="modalShow = !modalShow"
          v-b-modal.modal-prevent-closing
          pill
          variant="primary"
          class="col-xl-3 py-1 mx-0 mt-10 font-size-h5"
          >+ Add Your Task</b-button
        >
        <b-modal
          v-model="modalShow"
          id="modal-prevent-closing"
          ref="modal"
          centered
          title="Add Task"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleOk"
          hide-footer
        >
          <form ref="form" @submit.stop.prevent="handleSubmit">
            <h4 class="mb-10 font-weight-bold text-dark">
              Setup Your Task Details
            </h4>
            <!--YYYYYYYYYYYY task name-->
            <b-form-group
              label="Task Name*"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-input
                id="name-input"
                v-model="task.name"
                :state="nameState"
                placeholder="Enter Name"
                class="form-control form-control-solid form-control-lg"
                required
              ></b-form-input>
            </b-form-group>
            <!--YYYYYYYYYYYY task description-->
            <b-form-group
              label="Description"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-textarea
                id="textarea-rows"
                v-model="task.description"
                :state="nameState"
                placeholder="Describe Your Task..."
                class="form-control form-control-solid form-control-lg"
                rows="6"
                required
              ></b-form-textarea>
            </b-form-group>
            <!--YYYYYYYYYYYY Parent Task-->
            <b-form-group
              label="Parent Task"
              label-for="name-input"
              invalid-feedback="Name is required"
              class="font-weight-bold text-dark"
              :state="nameState"
            >
              <b-form-select
                v-model="task.parenttask"
                class="mb-3"
                value-field="item"
                text-field="name"
                ><b-form-select-option
                  v-for="task in parentanddependontask"
                  :key="task.name"
                  :value="task.id"
                  >{{ task.name }}</b-form-select-option
                ></b-form-select
              >
            </b-form-group>

            <!--YYYYYYYYYYYY DependOn Task-->
            <b-form-group
              label="Depend On Task"
              label-for="name-input"
              invalid-feedback="Name is required"
              class="font-weight-bold text-dark"
              :state="nameState"
            >
              <b-form-select v-model="task.dependontask" class="mb-3"
                ><b-form-select-option
                  v-for="task in parentanddependontask"
                  :key="task.name"
                  :value="task.id"
                  >{{ task.name }}</b-form-select-option
                >
              </b-form-select>
            </b-form-group>

            <!--YYYYYYYYYYYY Assign Task To Roles-->
            <b-form-group
              label="Assign Task To Roles"
              label-for="name-input"
              invalid-feedback="Name is required"
              class="font-weight-bold text-dark"
              :state="nameState"
            >
              <b-form-select v-model="task.assigntasktorole" class="mb-3"
                ><b-form-select-option
                  v-for="role in roles"
                  :key="role.adjictive"
                  :value="role.id"
                  >{{ role.adjictive }}</b-form-select-option
                >
              </b-form-select>
            </b-form-group>

            <!--YYYYYYYYYYYY Assign Task To User -->
            <div>
              <b-form-group
                label="Assign Task To Users"
                label-for="tags-with-dropdown"
              >
                <b-form-tags
                  id="tags-with-dropdown"
                  v-model="task.assigntasktousers"
                  no-outer-focus
                  class="mb-2"
                >
                  <template v-slot="{ tags, disabled, addTag, removeTag }">
                    <ul
                      v-if="tags.length > 0"
                      class="list-inline d-inline-block mb-2"
                    >
                      <li
                        v-for="tag in tags"
                        :key="tag"
                        class="list-inline-item"
                      >
                        <b-form-tag
                          @remove="removeTag(tag)"
                          :title="tag"
                          :disabled="disabled"
                          variant="info"
                          >{{ tag }}</b-form-tag
                        >
                      </li>
                    </ul>
                    <b-dropdown
                      size="sm"
                      variant="outline-secondary"
                      block
                      menu-class="w-100"
                    >
                      <template #button-content>
                        <b-icon icon="tag-fill"></b-icon> Choose tags
                      </template>
                      <b-dropdown-form @submit.stop.prevent="() => {}">
                        <b-form-group
                          label="Search tags"
                          label-for="tag-search-input"
                          label-cols-md="auto"
                          class="mb-0"
                          label-size="sm"
                          :description="searchDesc"
                          :disabled="disabled"
                        >
                          <b-form-input
                            v-model="search"
                            id="tag-search-input"
                            type="search"
                            size="sm"
                            autocomplete="off"
                          ></b-form-input>
                        </b-form-group>
                      </b-dropdown-form>
                      <b-dropdown-divider></b-dropdown-divider>
                      <b-dropdown-item-button
                        v-for="option in availableOptions"
                        :key="option.id"
                        @click="onOptionClick({ option, addTag })"
                      >
                        {{ option.FullName }}
                      </b-dropdown-item-button>
                      <b-dropdown-text v-if="availableOptions.length === 0">
                        There are no tags available to select
                      </b-dropdown-text>
                    </b-dropdown>
                  </template>
                </b-form-tags>
              </b-form-group>
            </div>
            <!-- <span>{{assigntasktorole}}</span>
            <span>{{assigntasktousers}}</span> -->
            <!--YYYYYYYYYYYYYYY start date-->
            <span>{{ task.t }}</span>
            <div class="col-xl-6">
              <div class="form-group">
                <label
                  class="font-weight-bold text-dark"
                  for="datepicker-buttons"
                  >Start Date</label
                >
                <b-form-datepicker
                  id="datepicker-buttons"
                  v-model="task.startdate"
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
                  v-model="task.enddate"
                  class="mb-2"
                ></b-form-datepicker>
              </div>
            </div>
            <!--YYYYYYYYYYYY Task buttons-->
            <!-- <span>{{ task }}</span> -->
            <!-- <span>{{ parentanddependontask }}</span> -->

            <div class="d-flex justify-content-between border-top pt-8">
              <div class="mr-2">
                <button
                  v-on:click="onSubmitAddTask"
                  class="btn btn-light-primary font-weight-bold text-uppercase px-6 py-2"
                  data-wizard-type="action-prev"
                >
                  Create Task
                </button>
              </div>
              <div>
                <button
                  v-on:click="$router.push('tasks')"
                  class="btn btn-success font-weight-bold text-uppercase px-6 py-2"
                  size="sm"
                  data-wizard-type="action-submit"
                >
                  Cancel
                </button>
              </div>
              <!-- <span>{{ task }}</span> -->
            </div>
          </form>
        </b-modal>
      </div>
    </div>

    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        Active Tasks
      </span>
    </div>

    <!-- begin Index Active Tasks-->

    <div class="card card-stretch gutter-b bg-light card-shadowless">
      <b-table
        :items="activetask"
        :fields="fields"
        hover
        head-row-variant="secondary"
      >
        <template #cell(actions)="row">
          <a href="#" class="btn btn-icon btn-light btn-sm mx-3 col-mr-11">
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg
                src="media/svg/icons/Navigation/Up-2.svg"
              ></inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>
          <a
            href="#"
            v-on:click="showtask(row.item.id)"
            class="btn btn-icon btn-light btn-sm mx-3"
            size="sm"
          >
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg src="media/svg/icons/Home/Library.svg"> </inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>
          <a
            href="#"
            v-on:click="edittask(row.item.id)"
            class="btn btn-icon btn-light btn-sm mx-3"
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
            class="btn btn-icon btn-light btn-sm"
            v-on:click="deleteTask(row.item.id)"
          >
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg src="media/svg/icons/General/Trash.svg"></inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>
          <!-- <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
          >
            Pull
          </b-button>
          <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
            v-on:click="$router.push('showtasks')"

          >
            Show
          </b-button>
           <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
            v-on:click="$router.push('showtasks')"

          >
            Edit
          </b-button>
           <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
            v-on:click="$router.push('showtasks')"

          >
            Delete
          </b-button> -->
        </template>
      </b-table>
    </div>
    <!-- begin Index Pinned Tasks-->
    <!-- <span>{{ activetask }}</span> -->
    <!-- <span>{{ roles }}</span>
    <span>{{ users }}</span> -->

    <br />
    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        Completed Tasks
      </span>
    </div>
    <div class="card card-stretch gutter-b bg-light card-shadowless">
      <b-table
        :items="completedtask"
        :fields="fields"
        hover
        head-row-variant="secondary"
      >
        <template #cell(actions)="row">
          <a href="#" class="btn btn-icon btn-light btn-sm mx-3 col-mr-11">
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg
                src="media/svg/icons/Navigation/Up-2.svg"
              ></inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>
          <a
            href="#"
            v-on:click="showtask(row.item.id)"
            class="btn btn-icon btn-light btn-sm mx-3"
            size="sm"
          >
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg src="media/svg/icons/Home/Library.svg"> </inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>

          <!-- <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
          >
            Pull
          </b-button>
          <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
            v-on:click="$router.push('showtasks')"

          >
            Show
          </b-button>
           <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
            v-on:click="$router.push('showtasks')"

          >
            Edit
          </b-button>
           <b-button
            size="sm"
            @click="info(row.item, row.index, $event.target)"
            class="ml-2 pr-3"
            v-on:click="$router.push('showtasks')"

          >
            Delete
          </b-button> -->
        </template>
      </b-table>
    </div>

    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        My Tasks
      </span>
    </div>
    <div class="card card-stretch gutter-b bg-light card-shadowless">
      <b-table
        :items="mytasks"
        :fields="fields1"
        hover
        head-row-variant="secondary"
      >
        <template #cell(actions)="row">
          <a href="#" class="btn btn-icon btn-light btn-sm mx-3 col-mr-11">
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg
                src="media/svg/icons/Navigation/Up-2.svg"
              ></inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>
          <a
            href="#"
            v-on:click="showtask(row.item.id)"
            class="btn btn-icon btn-light btn-sm mx-3"
            size="sm"
          >
            <span class="svg-icon svg-icon-md svg-icon-primary">
              <!--begin::Svg Icon-->
              <inline-svg src="media/svg/icons/Home/Library.svg"> </inline-svg>
              <!--end::Svg Icon-->
            </span>
          </a>
        </template>
      </b-table>
    </div>
    <span>{{ mytask }}</span>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
//import DropdownTasks from "@/view/pages/Dropdown/DropdownTasks.vue";
import axios from "axios";
import router from "@/router.js";
export default {
  // name: "widget-3",
  components: {
    //DropdownTasks
  },
  data() {
    return {
      options: ["Admin", "Manager", "Project Manager"],
      search: "",
      value: [],
      roles: "",
      users: "",
      projectid: localStorage.getItem("projectid"),
      task: {
        name: "",
        description: "",
        parenttask: "",
        dependontask: "",
        // typeofproject: "",
        startdate: "",
        enddate: "",
        assigntasktorole: "",
        assigntasktousers: "",
        t: [],
        nameState: null,
        modalShow: false,

        // status: "",
      },
      parentanddependontask: "",
      mytasks: "",
      completedtask: "",
      activetask: "",
      selected: "",
      opt: [
        { item: "A", name: "Project Task 01" },
        { item: "B", name: "Parent SubTask 01" },
        { item: "C", name: "Parent SubTask 02" },
        { item: "D", name: "SubTask 01" },
        { item: "E", name: "SubTask 02" },
        { item: "F", name: "SubTask 03" },
        { item: "G", name: "SubTask 04" },

        // { item: { d: 1 }, name: 'Option D' }
      ],
      show: true,

      selection: null,
      select: null,
      items: [
        { Name: "task1", Type: "", Status: "", Created_By: "" },
        { Name: "task2", Type: "", Status: "", Created_By: "" },
        { Name: "task3", Type: "", Status: "", Created_By: "" },
      ],
      fields: [
        "name",
        "description",
        "type",
        "CreatedBy",
        "startdate",
        "enddate",

        { key: "actions", label: "Actions" },
      ],
       fields1: [
        "name",
        "description",
        "type",
        "startdate",
        "enddate",

        { key: "actions", label: "Actions" },
      ],
    };
  },

  methods: {
    edittask(id) {
      localStorage.setItem("taskid", id);

      router.replace("/edittasks");
    },
    showtask(id) {
      localStorage.setItem("taskid", id);

      router.replace("/showtasks");
    },
    deleteTask(id) {
      axios({
        method: "delete",
        url: `http://127.0.0.1:8000/api/task/${id}`,
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      });
      // .then((response) => {
      //   this.activetask = response.data.projecttask;
      // });
    },
    onSubmitAddTask() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/task",
        data: {
          name: this.task.name,
          description: this.task.description,
          startdate: this.task.startdate,
          enddate: this.task.enddate,
          dependontask: this.task.dependontask,
          parent: this.task.parenttask,
          Role: this.task.assigntasktorole,
          AssignedUserId: this.task.t,
          projectid: this.projectid,
          // managerid: this.workspace.managerid,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then(function(response) {
        if (response.status == 201) {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-prevent-closing");
          });
        }
      });
    },
    onOptionClick({ option, addTag }) {
      addTag(option.FullName);
      this.task.t.push(option.id);
      this.search = "";
    },
  },
  computed: {
    ...mapGetters(["layoutConfig"]),
    criteria() {
      // Compute the search criteria
      return this.search.trim().toLowerCase();
    },
    availableOptions() {
      const criteria = this.criteria;
      // Filter out already selected options
      const options = this.options.filter(
        (opt) => this.value.indexOf(opt) === -1
      );
      if (criteria) {
        // Show only options that match criteria
        return options.filter(
          (opt) => opt.toLowerCase().indexOf(criteria) > -1
        );
      }
      // Show all options available
      return options;
    },
    searchDesc() {
      if (this.criteria && this.availableOptions.length === 0) {
        return "There are no tags matching your search criteria";
      }
      return "";
    },
  },
  created: function() {
    axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/taskindex/${this.projectid}`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.activetask = response.data.projecttask;
      this.completedtask = response.data.CompletedProjectTask;
      this.mytasks = response.data.mytasks;
    });
    axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/task/create/${this.projectid}`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.parentanddependontask = response.data.tasks;
      this.roles = response.data.roles;
      this.options = response.data.users;
    });
  },
};
</script>

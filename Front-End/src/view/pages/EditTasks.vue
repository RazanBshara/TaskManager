<template>
  <div>
    <!--begin:Nav-->
    <!--end: Nav-->
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
            :key="role.FullName"
            :value="role.id"
            >{{ role.FullName }}</b-form-select-option
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
                <li v-for="tag in tags" :key="tag" class="list-inline-item">
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
      <span>{{ task.t }}</span>
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

      <!-- <span>{{ roles }}</span> -->
      <!-- <span>{{ parentanddependontask }}</span> -->

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

    </form>

    <!--end: Wizard Body-->
  </div>
</template>

<style lang="scss">
@import "@/assets/sass/pages/wizard/wizard-1.scss";
</style>

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
      taskid: localStorage.getItem("taskid"),
      projectid: localStorage.getItem("projectid"),
      t: [],
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
        
        nameState: null,
        modalShow: false,

        // status: "",
      },
      parentanddependontask: "",
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
        "created_By",
        "startdate",
        "enddate",

        { key: "actions", label: "Actions" },
      ],
    };
  },

  methods: {
    showtask(id) {
      localStorage.setItem("taskid", id);

      // router.replace("/showtasks");
    },
    onSubmitAddTask() {
      axios({
        method: "put",
        url: `http://127.0.0.1:8000/api/task/${this.taskid}`,
        data: {
          name: this.task.name,
          description: this.task.description,
          enddate: this.task.enddate,
          dependontask: this.task.dependontask,
          parent: this.task.parenttask,
          Role: this.task.assigntasktorole,
          AssignedUserId: this.t,

        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then(function(response) {
        if (
          response.status === 201 ||
          response.status === 204 ||
          response.status === 200
        ) {
          console.log(JSON.stringify(response.data)), router.replace("/tasks");
        }
      });
    },
    onOptionClick({ option, addTag }) {
      addTag(option.FullName);
      this.t.push(option.id);
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
    });
    axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/task/${this.taskid}/edit`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.parentanddependontask = response.data.tasks;
      this.roles = response.data.roles.data;
      this.options = response.data.users.data;
      this.task = response.data.OrginalTask;
    });
  },
};
</script>

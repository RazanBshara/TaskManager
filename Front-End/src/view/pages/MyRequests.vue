<template>
  <div>
    <!--YYY begin header-->
    <div>
      <b-nav class="mx-2">
        <b-item class="font-size-h1 font-weight-weight">My Requests</b-item>
      </b-nav>
    </div>
    <br />

    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        Ticket
      </span>
    </div>
    <!--YYY begin Ticket Card-->
    <b-card bg-variant="light">
      <div>
        <b-table :items="task.ticket" :fields="fields" striped responsive="sm">
          <!-- Using buttons -->

          <template #cell(show_details)="row">
            <b-button
              size="sm"
              @click="row.toggleDetails"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
            >
              {{ row.detailsShowing ? "Hide" : "Show" }} Details
            </b-button>
            <b-button
              pill
              variant="danger"
              class=" m-1 btn btn-light-primary font-weight-bold px-6 py-1"
              @click="approveticket(row.item.id)"
              >Approve</b-button
            >

            <b-button
              pill
              @click="rejectTicket(row.item.id)"
              variant="danger"
              class=" m-1 btn btn-light-primary font-weight-bold px-6 py-1"
              v-b-modal.modal-prevent-closing
              >Reject</b-button
            >
            <!-- <b-modal
              v-model="modalShow"
              id="modal-prevent-closing"
              ref="modal"
              title="Enter your reject reason!"
              @show="resetModal"
              @hidden="resetModal"
              @ok="handleOk"
            >
              <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                  label="Enter text"
                  label-for="name-input"
                  invalid-feedback="Name is required"
                  :state="nameState"
                >
                  <b-form-input
                    id="name-input"
                    v-model="name"
                    :state="nameState"
                    required
                  ></b-form-input>
                </b-form-group>
              </form>
            </b-modal> -->
          </template>

          <template #row-details="row">
            <b-card>
              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Description:</b></b-col>
                <b-col>{{ row.item.description }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Start Date:</b></b-col>
                <b-col>{{ row.item.startdate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>End Date:</b></b-col>
                <b-col>{{ row.item.enddate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Status:</b></b-col>
                <b-col>{{ row.item.status }}</b-col>
              </b-row>
            </b-card>
          </template>
        </b-table>
      </div>
    </b-card>
    <br /><br />
    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        Binding Approve Task
      </span>
    </div>
    <!--YYY begin binding aprove task Card-->
    <!-- <span>{{task}}</span> -->
    <b-card bg-variant="light">
      <div>
        <b-table
          :items="task.approveprocesstask"
          :fields="fields1"
          striped
          responsive="sm"
        >
          <!-- Using buttons -->

          <template #cell(show_details)="row">
            <b-button
              size="sm"
              @click="row.toggleDetails"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
            >
              {{ row.detailsShowing ? "Hide" : "Show" }} Details
            </b-button>

            <b-button
              pill
              variant="danger"
              class=" m-1 btn btn-light-primary font-weight-bold px-6 py-1"
              @click="approveTask(row.item.id)"
              >Approve</b-button
            >

            <b-button
              pill
              @click="rejectTask(row.item.id)"
              variant="danger"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
              v-b-modal.modal-prevent-closing
              >Reject</b-button
            >
            <!-- <b-modal
              v-model="modalShow"
              id="modal-prevent-closing"
              ref="modal"
              title="Enter your reject reason!"
              @show="resetModal"
              @hidden="resetModal"
              @ok="handleOk"
            >
              <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                  label="Enter text"
                  label-for="name-input"
                  invalid-feedback="Name is required"
                  :state="nameState"
                >
                  <b-form-input
                    id="name-input"
                    v-model="name"
                    :state="nameState"
                    required
                  ></b-form-input>
                </b-form-group>
              </form>
            </b-modal> -->
          </template>

          <template #row-details="row">
            <b-card>
              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Description:</b></b-col>
                <b-col>{{ row.item.description }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Start Date:</b></b-col>
                <b-col>{{ row.item.startdate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>End Date:</b></b-col>
                <b-col>{{ row.item.enddate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Priority:</b></b-col>
                <b-col>{{ row.item.priority }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Type:</b></b-col>
                <b-col>{{ row.item.type }}</b-col>
              </b-row>
            </b-card>
          </template>
        </b-table>
      </div>
    </b-card>
    <br /><br />
    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        Binding Confirm Task
      </span>
    </div>
    <!--YYY begin binding confirm task Card-->
    <b-card bg-variant="light">
      <div>
        <b-table
          :items="task.confirmprocesstask"
          :fields="fields1"
          striped
          responsive="sm"
        >
          <!-- Using buttons -->

          <template #cell(show_details)="row">
            <b-button
              size="sm"
              @click="row.toggleDetails"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
            >
              {{ row.detailsShowing ? "Hide" : "Show" }} Details
            </b-button>

            <b-button
              pill
              variant="danger"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
              @click="confirmTask(row.item.id)"
              >Confirm</b-button
            >
            <!-- <b-modal
              v-model="modalShow"
              id="modal-prevent-closing"
              ref="modal"
              title="Enter your reject reason!"
              @show="resetModal"
              @hidden="resetModal"
              @ok="handleOk"
              hide-footer="true"
            >
              <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                  label="Enter text"
                  label-for="name-input"
                  invalid-feedback="Name is required"
                  :state="nameState"
                >
                  <b-form-input
                    id="name-input"
                    v-model="name"
                    :state="nameState"
                    required
                  ></b-form-input>
                </b-form-group>
              </form>
            </b-modal> -->
          </template>

          <template #row-details="row">
            <b-card>
              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Description:</b></b-col>
                <b-col>{{ row.item.description }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Start Date:</b></b-col>
                <b-col>{{ row.item.startdate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>End Date:</b></b-col>
                <b-col>{{ row.item.enddate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Priority:</b></b-col>
                <b-col>{{ row.item.priority }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Type:</b></b-col>
                <b-col>{{ row.item.type }}</b-col>
              </b-row>
            </b-card>
          </template>
        </b-table>
      </div>
    </b-card>
    <br /><br />
    <!--YYY begin Project Task Card-->
    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        Project Task
      </span>
    </div>
    <b-card bg-variant="light">
      <div>
        <b-table
          :items="task.projecttask"
          :fields="fields2"
          striped
          responsive="sm"
        >
          <!-- Using buttons -->

          <template #cell(show_details)="row">
            <b-button
              size="sm"
              @click="row.toggleDetails"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
            >
              {{ row.detailsShowing ? "Hide" : "Show" }} Details
            </b-button>
            <b-button
              pill
              variant="danger"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
              @click="submitToReviewTask(row.item.id)"
              >Submit</b-button
            >

            <!-- <b-modal
              v-model="modalShow"
              id="modal-prevent-closing"
              ref="modal"
              title="Enter your reject reason!"
              @show="resetModal"
              @hidden="resetModal"
              @ok="handleOk"
            >
              <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                  label="Enter text"
                  label-for="name-input"
                  invalid-feedback="Name is required"
                  :state="nameState"
                >
                  <b-form-input
                    id="name-input"
                    v-model="name"
                    :state="nameState"
                    required
                  ></b-form-input>
                </b-form-group>
              </form>
            </b-modal> -->
          </template>

          <template #row-details="row">
            <b-card>
              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Description:</b></b-col>
                <b-col>{{ row.item.description }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Start Date:</b></b-col>
                <b-col>{{ row.item.startdate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>End Date:</b></b-col>
                <b-col>{{ row.item.enddate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Priority:</b></b-col>
                <b-col>{{ row.item.priority }}</b-col>
              </b-row>
            </b-card>
          </template>
        </b-table>
      </div>
    </b-card>
    <div class="mt-10 mb-4">
      <span class="text-muted mt-12 font-weight-bold font-size-md">
        My Tasks
      </span>
    </div>
    <!--YYY begin Ticket Card-->
    <b-card bg-variant="light">
      <div>
        <b-table :items="task.mytasks" :fields="fields3" striped responsive="sm">
          <!-- Using buttons -->

          <template #cell(show_details)="row">
            <b-button
              size="sm"
              @click="row.toggleDetails"
              class="m-1 btn btn-light-primary font-weight-bold px-6 py-1"
            >
              {{ row.detailsShowing ? "Hide" : "Show" }} Details
            </b-button>
          </template>

          <template #row-details="row">
            <b-card>
              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Description:</b></b-col>
                <b-col>{{ row.item.description }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Start Date:</b></b-col>
                <b-col>{{ row.item.startdate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>End Date:</b></b-col>
                <b-col>{{ row.item.enddate }}</b-col>
              </b-row>

              <b-row class="mb-2">
                <b-col sm="3" class="text-sm-right"><b>Status:</b></b-col>
                <b-col>{{ row.item.status }}</b-col>
              </b-row>
            </b-card>
          </template>
        </b-table>
      </div>
    </b-card>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      modalShow: false,
      res: {},
      name: "",
      nameState: null,
      submittedNames: [],
      // description: "",
      fields: ["Ticket", "type", "CreatedBy", "show_details"],
      fields1: ["Task", "status", "CreatedBy", "show_details"],
      fields2: [
        "name",
        "Project",
        "status",
        "type",
        "CreatedBy",
        "show_details",
      ],
      fields3: [
        "name",
        "Project",
        "priority",
        "type",
        "CreatedBy",
        "show_details",
      ],
      items: [{ tickets: "ticket-1" }],
      task: {
        confirmprocesstask: "",
        approveprocesstask: "",
        projecttask: "",
        ticket: "",
        mytasks: "",
      },
      mytask: {
        ticket: [],
        processtask: [],
        projecttask: [],
      },
    };
  },
  methods: {
    submitToReviewTask(id) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/submittoreview",
        data: {
          taskid: id,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      });
      // .then(function(response) {
      //   if (response.status == 201) {
      //     this.$nextTick(() => {
      //       this.$bvModal.hide("modal-prevent-closing");
      //     });
      //   }
      // });
    },
    rejectTicket(id) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/rejectticket",
        data: {
          ticket: id,
          description: this.description,
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
        this.description = "";
      });
    },
    approveticket(id) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/approveticket",
        data: {
          ticketid: id,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      });
      // .then(function(response) {
      //   if (response.status == 201) {
      //     this.$nextTick(() => {
      //       this.$bvModal.hide("modal-prevent-closing");
      //     });
      //   }
      // });
    },
    approveTask(id) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/approvetask",
        data: {
          taskid: id,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      });
      // .then(function(response) {
      //   if (response.status == 201) {
      //     this.$nextTick(() => {
      //       this.$bvModal.hide("modal-prevent-closing");
      //     });
      //   }
      // });
    },
    rejectTask(id) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/rejecttask",
        data: {
          taskid: id,
          description: this.description,
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
        this.description = "";
      });
    },
    confirmTask(id) {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/confirmtask",
        data: {
          taskid: id,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      });
      // .then(function(response) {
      //   if (response.status == 201) {
      //     this.$nextTick(() => {
      //       this.$bvModal.hide("modal-prevent-closing");
      //     });
      //   }
      // });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      this.name = "";
      this.nameState = null;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return;
      }
      // Push the name to submitted names
      this.submittedNames.push(this.name);
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
  },
  created: function() {
    axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/task`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.task.ticket = response.data.ticket;
      this.task.confirmprocesstask = response.data.confirmprocesstask;
      this.task.approveprocesstask = response.data.approveprocesstask;
      this.task.projecttask = response.data.projecttask;
      this.task.mytasks = response.data.mytasks;
    });
  },
};
</script>

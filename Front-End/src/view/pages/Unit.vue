<template>
  <div class="mt-1">
    <!--YYY begin header-->
    <div>
      <b-nav class="mx-1">
        <b-item class="font-size-h1 font-weight-weight">Unit</b-item>
        <!-- <b-nav-item>Complete Projects</b-nav-item> -->
      </b-nav>
    </div>
    <!-- begin add project-->
    <div class="row">
      <div class="col-md-8 text-left left-0">
        <b-button
          v-on:click="$router.push('createunit')"
          pill
          variant="primary"
          class="col-xl-3 py-1 mx-0 mt-10 font-size-h5"
          >+ Create a Unit</b-button
        >
      </div>
    </div>
    <br />
    <!-- begin::Header-->
    <!-- <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
          <span class="card-label font-weight-bolder font-size-h2 text-dark">
            Tasks
          </span>
        </h3>
        <div class="card-toolbar">
        <DropdownTasks></DropdownTasks>
      </div> -->

    <!-- <span class="text-muted mt-3 font-weight-bold font-size-sm">
          More than 400+ new members
        </span> -->
    <!-- <div class="card-toolbar"> 
          <ul class="nav nav-pills nav-pills-sm nav-dark-75">
            <li class="nav-item">
              <a
                class="nav-link py-2 px-4 active"
                data-toggle="tab"
                href="#kt_tab_pane_1_1"
              >
                Month
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link py-2 px-4"
                data-toggle="tab"
                href="#kt_tab_pane_1_2"
              >
                Week
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link py-2 px-4"
                data-toggle="tab"
                href="#kt_tab_pane_1_3"
              >
                Day
              </a>
            </li>
          </ul>
        
      </div> -->
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-3 pb-0">
      <!--begin::Table-->
      <b-card>
        <div class="table-responsive">
          <b-table
            :items="unit"
            :fields="fields"
            striped
            class="table table-borderless table-vertical-center"
           >
            <!-- <thead>
            <tr>
              <th class="p-0" style="width: 50px"></th>
              <th class="p-0" style="min-width: 200px"></th>
              <th class="p-0" style="min-width: 100px"></th>
              <th class="p-0" style="min-width: 125px"></th>
              <th class="p-0" style="min-width: 110px"></th>
              <th class="p-0" style="min-width: 150px"></th>
            </tr>
           </thead> -->
            <tbody>
              <template v-for="(item, i) in list">
                <tr v-bind:key="i">
                  <td class="pl-0 py-4">
                    <div class="symbol symbol-50 symbol-light mr-0">
                      <span class="symbol-label">
                        <img
                          :src="item.text0"
                          class="h-50 align-self-center"
                          alt=""
                        />
                        <a
                          href="#"
                          class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"
                        >
                          {{ row.item.name }}
                        </a>
                      </span>
                    </div>
                  </td>

                  <td class="text-right">
                    <h6>Description</h6>
                    <span class="text-muted font-weight-500">
                      {{ row.item.description }}
                    </span>
                  </td>

                  <!-- <div>
                      <span class="font-weight-bolder">description</span>
                      <a
                        class="text-muted font-weight-bold text-hover-primary"
                        href="#"
                      >
                        {{ item.description }}
                      </a>
                    </div>  -->

                  <!-- <td class="text-right">
                  <span
                    class="text-dark-75 font-weight-bolder d-block font-size-lg"
                  >
                    {{ item.text3 }}
                  </span>
                  <span class="text-muted font-weight-bold">Paid</span>
                 </td> -->
                  <td class="text-right">
                    <h6>Workspace</h6>
                    <span class="text-muted font-weight-500">
                      {{ row.item.workspaceid }}
                    </span>
                  </td>

                  <td class="text-right">
                    <h6>Department</h6>
                    <span class="text-muted font-weight-500">
                      {{ row.item.departmentid }}
                    </span>
                  </td>
                  
                  <td class="text-right">
                    <h6>Head Of Unit</h6>
                    <span class="text-muted font-weight-500">
                      {{ row.item.HOU }}
                    </span>
                  </td> 
                  <td class="text-right pr-0">
                    <a href="#" class="btn btn-icon btn-light btn-sm mx-3">
                      <span class="svg-icon svg-icon-md svg-icon-primary">
                        <!--begin::Svg Icon-->
                        <inline-svg
                          src="media/svg/icons/Communication/Write.svg"
                        ></inline-svg>
                        <!--end::Svg Icon-->
                      </span>
                    </a>
                    <a href="#" class="btn btn-icon btn-light btn-sm">
                      <span class="svg-icon svg-icon-md svg-icon-primary">
                        <!--begin::Svg Icon-->
                        <inline-svg
                          src="media/svg/icons/General/Trash.svg"
                        ></inline-svg>
                        <!--end::Svg Icon-->
                      </span>
                    </a>
                  </td>
                </tr>
              </template>
            </tbody>
          </b-table>
        </div>
        <!-- <span>{{unit}}</span> -->
        <!-- end::Table -->
      </b-card>
    </div>
  </div>
  <!--end::Body-->
  <!-- </div> -->
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
//import DropdownTasks from "@/view/pages/Dropdown/DropdownTasks.vue";

export default {
  name: "widget-3",
  components: {
    // DropdownTasks
  },
  data() {
    return {
      unit: {},
      fields: ["name", "description", "workspace", "department", "HOU"],
      items: [
        {
          name: "Unit 1",
          description: "sdhnskjiedjsnkjn",
          workspace: "Rddddddddddjnkn",
          department: "A3dxcjnvdsjnv",
          HOU: "444",
        },
        {
          name: "Unit 2",
          description: "Payrol Application",
          workspace: "ReactJs, HTML",
          department: "Approved",
          HOU: "primary",
        },
        {
          name: "Unit 3",
          description: "Payrol Application",
          workspace: "ReactJs, HTML",
          department: "Approved",
          HOU: "primary",
        },
        {
          name: "Unit 4",
          description: "Payrol Application",
          workspace: "ReactJs, HTML",
          department: "Approved",
          HOU: "primary",
        },
        {
          name: "Unit 5",
          description: "Payrol Application",
          workspace: "ReactJs, HTML",
          department: "Approved",
          HOU: "primary",
        },
      ],
      // list: [
      //   {
      //     name: "Unit 1",
      //     description: "sdhnskjiedjsnkjn",
      //     workspaceid: "Rddddddddddjnkn",
      //     departmentid: "A3dxcjnvdsjnv",
      //     hou: "444",
      //   },
      //   {
      //     name: "Unit 2",
      //     description: "Payrol Application",
      //     workspaceid: "ReactJs, HTML",
      //     departmentid: "Approved",
      //     hou: "primary",
      //   },
      //   {
      //     name: "Unit 3",
      //     description: "Payrol Application",
      //     workspaceid: "ReactJs, HTML",
      //     departmentid: "Approved",
      //     hou: "primary",
      //   },
      //   {
      //     name: "Unit 4",
      //     description: "Payrol Application",
      //     workspaceid: "ReactJs, HTML",
      //     departmentid: "Approved",
      //     hou: "primary",
      //   },
      //   {
      //     name: "Unit 5",
      //     description: "Payrol Application",
      //     workspaceid: "ReactJs, HTML",
      //     departmentid: "Approved",
      //     hou: "primary",
      //   },
      // ],
    };
  },
  created: function() {
    axios
      .get("http://127.0.0.1:8000/api/unit", {
        // params:{

        // },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      })
      .then((response) => {
        this.unit = response.data.data;
      });
  },
  computed: {
    ...mapGetters(["layoutConfig"]),
  },
};
</script>

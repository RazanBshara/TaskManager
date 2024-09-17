<template>
  <div>
    <b-modal
      v-model="modalShow"
      id="modal-prevent-closing"
      ref="modal"
      centered
      title="Add Your Workflow"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      hide-footer="true"
    >
      <b-form-group
        label="Tagged input using select"
        label-for="tags-component-select"
      >
        <!-- Prop add-on-change is needed to enable adding tags vie the change event -->
        <b-form-tags
          id="tags-component-select"
          v-model="value"
          size="lg"
          class="mb-2"
          add-on-change
          no-outer-focus
        >
          <template
            v-slot="{ tags, inputAttrs, inputHandlers, disabled, removeTag }"
          >
            <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
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
            <b-form-select
              v-bind="inputAttrs"
              v-on="inputHandlers"
              :disabled="disabled || availableOptions.length === 0"
              :options="availableOptions"
            >
              <template #first>
                <!-- This is required to prevent bugs with Safari -->
                <option disabled value="">Selectv a Level...</option>
              </template>
            </b-form-select>
          </template>
        </b-form-tags>
      </b-form-group>
      <div class="d-flex justify-content-between border-top pt-8">
        <div class="mr-2">
          <button
            class="btn btn-light-primary font-weight-bold px-6 py-2"
            data-wizard-type="action-prev"
          >
            Create Workflow
          </button>
        </div>
        <div>
          <button
            v-on:click="$router.push('workspace')"
            class="btn btn-success font-weight-bold px-6 py-2"
            data-wizard-type="action-submit"
          >
            Cancel
          </button>
        </div>
        <!-- <span>{{ projectManagersGeted }}</span> -->
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
                modalShow: true,

      options: [
        "Company Level",
        "Department Level",
        "Unit Level",
        "Section Level",
        "Task Level",
      ],
      value: [],
    
};
    
  },
  computed: {
    availableOptions() {
      return this.options.filter((opt) => this.value.indexOf(opt) === -1);
    },
  },
};
</script>

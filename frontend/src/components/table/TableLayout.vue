<template>
  <div>
    <div class="flex items-center justify-between flex-wrap gap-4 p-4">
      <div class="flex justify-between items-center">
        <a-button
          v-if="hasSelected"
          type="primary"
          :loading="state.loading"
          class="mr-2"
          disabled
          @click="$emit('btnFunction', state.selectedRowKeys)"
        >
          {{ buttonPlaceholder }}
        </a-button>

        <template v-if="hasSelected">
          {{ `Selected ${state.selectedRowKeys.length} items ` }}
        </template>
      </div>

      <a-pagination
        :pageSize="pagination.pageSize"
        :total="pagination.total"
        :current="pagination.currentPage"
        @change="onChangePage"
      />
    </div>
    <a-table
      :row-selection="{
        selectedRowKeys: state.selectedRowKeys,
        onChange: onSelectChange,
      }"
      :loading="loading"
      :columns="columns"
      :pagination="false"
      :data-source="dataSource"
      :row-key="rowKey"
    >
      <template #bodyCell="{ column, record }">
        <template v-if="column.key === 'actions'">
          <a-button @click="$emit('showModalFunc', record)" type="primary"
            >View</a-button
          >
        </template>
      </template>
    </a-table>
  </div>
</template>

<script setup lang="ts">
import type { IColumn  , IPagination} from "@/dto/types";
import { reactive, computed } from "vue";

defineProps<{
  columns: IColumn[];
  dataSource: any[];
  loading:boolean,
  buttonPlaceholder: string;
  pagination:IPagination
}>();

const state = reactive<{
  selectedRowKeys: string[];
  loading: boolean;
  message?: string;
}>({
  loading: false,
  message: "",
  selectedRowKeys: [],
});


const emit = defineEmits(["pageOption", "btnFunction", "showModalFunc"]) // this was done so i can emit this value to the parent component

const onSelectChange = (selectedRowKeys: string[]) => {
  state.selectedRowKeys = selectedRowKeys;
};

const rowKey = (dataSource: any) => {
  return dataSource.id;
};

const onChangePage = (page:any) => {
    emit('pageOption' , page)
}



const hasSelected = computed(() => state.selectedRowKeys.length > 0);
</script>

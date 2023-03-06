<template>
  <main>
    <tableLayout
      :columns="columns"
      :data-source="tableData"
      :loading="loading"
      :button-placeholder="'Update Weather'"
      @btn-function="update($event)"
      @show-modal-func="handleModal($event)"
    ></tableLayout>

    <a-modal
      v-model:visible="showModal"
      title="User Weather"
      @ok="showModal = !showModal"
    >
      <p>Id : {{ user?.id }}</p>
      <p>Name : {{ user?.name }}</p>
      <p>Latitude: {{ user?.latitude }}</p>
      <p>Longitude: {{ user?.longitude }}</p>
      <p>Weather: {{ user?.weather }}</p>
      <p>Weather Description : {{ user?.description }}</p>
      <p></p>
    </a-modal>
  </main>
</template>

<script lang="ts">
import moment from "moment";
import TableLayout from "@/components/table/TableLayout.vue";
import { fetchUsers } from "@/services/userService";
import type { IDataSource, ITableData, IColumn } from "@/dto/types";

export default {
  components: {
    TableLayout,
  },

  data() {
    return {
      columns: [
        {
          title: "Name",
          dataIndex: "name",
          key: "name",
          scopedSlots: { customRender: "name" },
        },
        {
          title: "Email",
          dataIndex: "email",
          key: "email",
          scopedSlots: { customRender: "email" },
        },
        {
          title: "Longitude",
          dataIndex: "longitude",
          key: "longitude",
          scopedSlots: { customRender: "longitude" },
        },

        {
          title: "Latitude",
          dataIndex: "latitude",
          key: "latitude",
          scopedSlots: { customRender: "latitude" },
        },
        {
          title: "Weather",
          dataIndex: "weather",
          key: "weather",
          scopedSlots: { customRender: "weather" },
        },
        {
          title: "Action",
          key: "actions",
          scopedSlots: { customRender: "actions" },
        },
      ] as IColumn[],
      dataSource: [] as IDataSource[],
      tableData: [] as ITableData[],
      showModal: false,
      user: {} as ITableData,
      selectedRow: [] as string[],
      loading: false,
    };
  },

  created() {
    this.fetchData();
  },

  methods: {
    formatTime(time: string) {
      if (time === null) {
        return "Never Connected";
      } else {
        return moment(time).fromNow();
      }
    },

    handleModal(record: any) {
      this.showModal = !this.showModal;
      this.user = record;
    },

    // this method is for bulk action for table data
    async update(selectedRow: string[]) {
      this.selectedRow = selectedRow;
    },

    async fetchData() {
      this.loading = true;
      const users = await fetchUsers();
      if (users.status) {
        this.dataSource = users.data as IDataSource[];

        if (this.dataSource.length) {
          this.tableData = users.data.map((user: IDataSource) => {
            return {
              id: user.id,
              name: user.name,
              email: user.email,
              latitude: user.longitude,
              longitude: user.latitude,
              weather: user.weather?.weather || "weather",
              description:
              user.weather?.weather_description || "weather description",
            };
          });
        }
      }
      this.loading = false;
    },
  },
};
</script>

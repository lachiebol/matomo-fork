<!--
  Matomo - free/libre analytics platform

  @link    https://matomo.org
  @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <button @click="toggleQuickStatsModal()">Click Me</button>

  <MatomoDialog v-model="showModal">
    <div>Hello</div>
  </MatomoDialog>

</template>

<style lang="less" scoped>

</style>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { MatomoDialog, AjaxHelper } from 'CoreHome';

interface VisitData {
  actions: string;
  vistors: string;
  visits: string;
  visitsConverted: string;
}

interface GetCountersResponse {
  data: Array<VisitData>;
}

export default defineComponent({
  components: {
    MatomoDialog,
  },
  setup() {
    const showModal = ref(false);
    const counters = ref<VisitData | null>(null);
    const error = ref<string | null>(null);
    return { showModal, counters };
  },
  methods: {
    getStatsFromAPI() {
      AjaxHelper.fetch<GetCountersResponse>(
        {
          module: 'API',
          method: 'Live.getCounters',
          idSite: 1,
          lastMinutes: 240, // TODO CHANGE ME
          format: 'json',
        },
      ).then((response) => {
        const stats=response[0];
        counters.value = {
          actions: stats.actions,
          visitors: stats.visitors,
          visits: stats.visits,
          visitsConverted: stats.visitsConverted,
        }
      }).catch((err) => {
        error.value=err;
      }).finally(() => {
        isLoading = false;
      });
    },
    toggleQuickStatsModal() {
      this.showModal = true;
      getStatsFromAPI();
    },
  },

});
</script>
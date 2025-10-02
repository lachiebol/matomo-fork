<!--
  Matomo - free/libre analytics platform

  @link    https://matomo.org
  @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <div id="quick-stats-button-container" class="borderedControl">
    <button @click="toggleQuickStatsModal()" class="btn">
      <span class="icon-evolution"></span>QUICK STATS
    </button>
  </div>

  <MatomoDialog v-model="showModal">
    <div>
      <h1 id="quick-stats-header">
        <span class="header-icon icon-evolution"></span>Quick Stats
      </h1>
      <h3 id="quick-stats-subheader">
        <span class="header-icon icon-clock"></span>Last 120 Minutes
      </h3>
      <div id="quick-stats-parent">
        <table v-content-table>
          <thead>
            <tr>
              <th><span class="icon-hits"></span> Actions</th>
              <th><span class="icon-visitor-profile"></span> Visitors</th>
              <th><span class="icon-reporting-visitors"></span> Visits</th>
              <th><span class="icon-rocket"></span> Visits Converted</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="counters">
              <td>{{ counters.actions }}</td>
              <td>{{ counters.visitors }}</td>
              <td>{{ counters.visits }}</td>
              <td>{{ counters.visitsConverted }}</td>
            </tr>
            <tr v-else-if="error">
              <td colspan="4" id="error-cell">
                <strong>Apologies, something didn't go quite right</strong>
              </td>
            </tr>
            <tr v-else-if="isLoading">
              <td colspan="4" id="loading-cell"><ActivityIndicator :loading="true"/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <input type="button" value="Close" role="ok"/>
    </div>
  </MatomoDialog>
</template>

<style lang="less" scoped>

.header-icon {
  margin-right: 10px;
}

#error-cell {
  color: #ff0000;
}

#loading-cell, #error-cell {
  text-align: center;
}

#quick-stats-button-container {
  display: flex;
  justify-content: center;
}

#quick-stats-parent {
  display: flex;
  justify-content: center;
}

#quick-stats-subheader {
  padding-left: 15px;
  margin-bottom: 10px;
}

#quick-stats-header {
  padding: 15px;
  background:#3450a3;
  color:#FFFFFF;
  border-radius: 2px;
  margin-bottom: 10px;
}

</style>

<script lang="ts">

import { defineComponent, ref } from 'vue';
import {
  MatomoDialog, AjaxHelper, ContentTable, ActivityIndicator,
} from 'CoreHome';

interface VisitData {
  actions: string;
  visitors: string;
  visits: string;
  visitsConverted: string;
}

type GetCountersResponse = VisitData[];

export default defineComponent({
  components: {
    MatomoDialog,
    ActivityIndicator,
  },
  directives: {
    ContentTable,
  },
  setup() {
    const counters = ref<VisitData | null>(null);
    const error = ref<string | null>(null);
    const isLoading = ref(true);

    function getStatsFromAPI() {
      AjaxHelper.fetch<GetCountersResponse>(
        {
          module: 'API',
          method: 'Live.getCounters',
          idSite: 1,
          lastMinutes: 120,
          format: 'json',
        },
      ).then((response) => {
        if (response[0]) {
          const stats = response[0];
          counters.value = {
            actions: stats.actions,
            visitors: stats.visitors,
            visits: stats.visits,
            visitsConverted: stats.visitsConverted,
          };
        } else error.value = 'Invalid response from API';
      }).catch((err) => {
        error.value = err;
        isLoading.value = false;
      }).finally(() => {
        isLoading.value = false;
      });
    }

    const showModal = ref(false);

    function toggleQuickStatsModal() {
      showModal.value = true;
      getStatsFromAPI();
    }

    return {
      showModal, counters, toggleQuickStatsModal, error, isLoading,
    };
  },
});
</script>

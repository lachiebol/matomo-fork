<!--
  Matomo - free/libre analytics platform

  @link    https://matomo.org
  @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <div id="quick-stats-button-container" class="borderedControl">
    <button id="quick-stats-button" @click="toggleQuickStatsModal()">QUICK STATS</button>
  </div>

  <MatomoDialog v-model="showModal">
    <div>
    <div id="quick-stats-header">Quick Stats</div>
      <div id="quick-stats-parent">
        <!-- <div id="quick-stats-container" v-if="counters">
          <div class="quick-stats-item">
            <span class="label">Actions:</span>{{counters.actions}}
          </div>
          <div class="quick-stats-item">
            <span class="label">Visitors:</span>{{counters.visitors}}
          </div>
          <div class="quick-stats-item">
            <span class="label">Visits:</span>{{counters.visits}}
          </div>
          <div class="quick-stats-item">
            <span class="label">Visits Converted:</span>{{counters.visitsConverted}}
          </div>
        </div> -->
        <div id="error-container" v-if="error">
          <div id="error-message"><strong>Apologies, something didn't go quite right</strong></div>
        </div>
        <div v-else>
          <MatomoLoader />
        </div>
    
      </div>
      <input type="button" value="Close" role="ok"/>
    </div>
  </MatomoDialog>

</template>

<style lang="less" scoped>


#error-message {
  color: #ff0000;
  text-align: center;
}


#quick-stats-button {
  background-color: #eff0f1;
  border: 0;
  transition: box-shadow 150ms linear;
  box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.16), 0 0px 3px 0 rgba(0, 0, 0, 0.12);
  border-radius: 2px;
  font-size: 11px;
  display: inline-block;
  padding: 10px 15px 11px 13px;
  cursor: pointer;
  color: #212121;
}

#quick-stats-button-container {
  display: flex;
  justify-content: center;
}

#quick-stats-container, #error-container {
  display: grid;
  width: 600px;
  background-color: #ffffff;
  border-radius: 2px;
  gap: 10px;
  padding: 10px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}


#quick-stats-parent {
  display: flex;
  justify-content: center;
}

#quick-stats-header {
  padding: 10px;
  text-align: center;
  background:#3450a3;
  color:#FFFFFF;
  font-size: 24pt;
  border-radius: 2px;
  margin-bottom: 10px;
}

.quick-stats-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-radius: 2px;
  font-weight: bold;
  padding: 10px;
  color: #1f2937;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  font-size: 20pt;
}

.quick-stats-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.quick-stats-item span.label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.quick-stats-item span.label::before {
  content: '-';
  color: #3450a3; 
}

</style>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { MatomoDialog, MatomoLoader, AjaxHelper } from 'CoreHome';

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

    function getStatsFromAPI() {
      AjaxHelper.fetch<GetCountersResponse>(
        {
          module: 'API',
          method: 'Live.getCounters',
          idSite: 1,
          lastMinutes: 240, // TODO CHANGE ME
          format: 'json',
        },
      ).then((response) => {
        const stats = response[0];
        counters.value = {
          actions: stats.actions,
          visitors: stats.visitors,
          visits: stats.visits,
          visitsConverted: stats.visitsConverted,
        };
      }).catch((err) => {
        error.value = err;
      });
    }

    function toggleQuickStatsModal() {
      this.showModal = true;
      getStatsFromAPI();
    }

    return { showModal, counters, toggleQuickStatsModal, error };
  },
});
</script>

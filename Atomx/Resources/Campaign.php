<?php namespace Atomx\Resources;

use Atomx\AtomxClient;
use InvalidArgumentException;

class Campaign extends AtomxClient {
    protected $endpoint = 'campaign';

    /**
     * @param $state State of the campaign (active/inactive)
     */
    public function setState($state)
    {
        if (!in_array($state, ['active', 'inactive']))
            throw new InvalidArgumentException('API: Invalid bid type provided');

        $this->state = strtoupper($state);
    }

    public function setBudget($amount)
    {
        if ($amount == 0)
            throw new InvalidArgumentException('API: Trying to set a campaign budget to unlimited (0)');

        $this->budget = $amount;
    }

    public function setDailyBudget($dailyBudget)
    {
        $this->budget_cap_amount = $dailyBudget / 24;
        $this->budget_cap_per    = 86400 / 24;
    }

    public function setBidType($type)
    {
        if (!in_array($type, ['CPM', 'dCPM', 'CPC', 'CPA']))
            throw new InvalidArgumentException('API: Invalid bid type provided');

        $this->pricemodel = $type;
    }

    public function setBidPrice($price)
    {
        $this->bid = $price;
    }

    public function setCreatives($activeCreatives, $inactiveCreatives)
    {
        $this->active_creatives   = $activeCreatives;
        $this->inactive_creatives = $inactiveCreatives;
    }
}
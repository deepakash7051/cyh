<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminProposalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function admin_proposal(){
        $result = [
            $this->first_proposal,
            $this->second_proposal,
            $this->third_proposal 
        ];
        return array_filter($result);
    }

    public function toArray($request)
    {
       // return parent::toArray($request);
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "portfolio_id" => $this->portfolio_id,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user" => $this->user,
            "portfolio" => $this->portfolio,
            "proposal_images" => $this->proposal_images,
            "payment_status" => $this->payment_status,
            "admin_proposals" => $this->admin_proposal()
        ];
    }
}

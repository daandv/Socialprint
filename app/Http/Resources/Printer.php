<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Printer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $printerArray = array();


        foreach ($this->resource as $printer) {
          $color = "";
          $format = "";
          $busNr = "";
            if ($printer->bus_number==0) {
              $busNr = "";
            } else {
              $busNr = "bus " . $printer->bus_number . ", ";
            }
            if ($printer->format_id=="1") {
              $format = "A4";
            }
            if ($printer->format_id=="2") {
              $format = "A3";
            }
            if ($printer->color_id=="1") {
              $color = "kleur";
            }
            if ($printer->color_id=="2") {
              $color = "z/w";
            }

            $printerArray[] = array(
                'id' => $printer->id,
                'name' => $printer->name,
                'profile_picture_url' => $printer->profile_picture_url,
                'lat' => $printer->lat,
                'lng' => $printer->lng,
                'streetAndNr' => $printer->street_and_number,
                'city' => $printer->city,
                'busNr' => $busNr,
                'printer_id' => $printer->printer_id,
                'price' => $printer->price,
                'color' => $color,
                'format' => $format,
            );
        }
        return $printerArray;
      }


}

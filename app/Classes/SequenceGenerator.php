<?php
namespace App\Classes;
use App\Models\Sequence;
use App\Models\SequencePeriod;
use Carbon\Carbon;

class SequenceGenerator {

    private $sequence;
    private $parameters;

    public function __construct($sequence, $parameters)
    {
        $this->sequence = $sequence;
        $this->parameters = $parameters;
    }

    public function getNext()
    {
        $sequenceNumber = '';
        try {
            if($this->sequence)
            {                
                if($this->sequence->use_date_range == 1)
                {
                    $sequencePeriod = SequencePeriod::where('sequence_id', $this->sequence->id)
                                    ->where(function($query)
                                    {
                                        $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
                                        $query->where(function($query) {
                                            $query->whereNull('expiry_date');
                                            $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
                                        });
                                    })
                                    ->orderBy('effective_date', 'ASC')
                                    ->first();
                    if($sequencePeriod)
                    {
                        $sequenceNumber = $this->getFormat($this->sequence->format, $this->sequencePeriod->number_next);
                        $this->updateNext($this->sequence, $sequencePeriod);    
                    }
                }
                else 
                {
                    $sequenceNumber = $this->getFormat($this->sequence->format, $this->sequence->number_next);
                    $this->updateNext($this->sequence, null);
                }
            }
        } catch (\Throwable $th) {
            
        }

        return $sequenceNumber;
    }

    private function updateNext($sequence, $sequencePeriod)
    {
        if($sequence->use_date_range == 1)
        {
            $sequencePeriod->number_next = $sequencePeriod->number_next + $sequence->number_increment;
            $sequencePeriod->save();
        }
        else 
        {
            $sequence->number_next = $sequence->number_next + $sequence->number_increment;
            $sequence->save();
        }
    }

    private function getFormat($format, $numberNext)
    {
        $now = Carbon::now();
        $romawi = array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');

        $format = str_replace('{D}', $now->isoFormat('D'), $format);
        $format = str_replace('{DD}', $now->isoFormat('DD'), $format);
        $format = str_replace('{dd}', $now->isoFormat('dd'), $format);
        $format = str_replace('{ddd}', $now->isoFormat('ddd'), $format);
        $format = str_replace('{dddd}', $now->isoFormat('dddd'), $format);

        $format = str_replace('{M}', $now->isoFormat('M'), $format);
        $format = str_replace('{MM}', $now->isoFormat('MM'), $format);
        $format = str_replace('{MMM}', $now->isoFormat('MMM'), $format);
        $format = str_replace('{MMMM}', $now->isoFormat('MMMM'), $format);

        $format = str_replace('{YY}', $now->isoFormat('YY'), $format);
        $format = str_replace('{YYYY}', $now->isoFormat('YYYY'), $format);

        $format = str_replace('{X}', $romawi[$now->isoFormat('M')-1], $format);

        $matches = array();
        preg_match_all('{[0-9]*-SEQ}', $format, $matches);
        for ($i=0; $i < count($matches[0]); $i++) { 
            $digits = explode('-',$matches[0][$i]);
            $format = preg_replace('{{[0-9]*-SEQ}}', str_pad($numberNext, $digits[0], "0", STR_PAD_LEFT), $format);
        }

        preg_match_all('{{(.*?)}}', $format, $matches);
        for ($i=0; $i < count($matches[0]); $i++) { 
            $key = str_replace('}', '', str_replace('{','', $matches[0][$i]));
            if($this->parameters && array_key_exists($key, $this->parameters)) {
                $format = str_replace($matches[0][$i], $this->parameters[$key], $format);
            } else {
                $format = str_replace($matches[0][$i], '', $format);
            }
            
        }

        return $format;
    }
}
<?php

namespace App\Filters;

use Illuminate\Http\Request;

class APIFilters {
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if(!isset($query)) continue;

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    if ($parm === 'doctor.id') {
                        // Use whereHas for the doctor relationship
                        $this->query->whereHas('doctor', function ($q) use ($query, $operator) {
                            $q->where('id', $this->operatorMap[$operator], $query[$operator]);
                        });
                    } else {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                    }
                }
            }
        }

        return $eloQuery;
    }
}
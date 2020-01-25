<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvestList;

class InvestListController extends Controller
{
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		$invest = InvestList::all()->toArray();
		return view('invest-list-data.index',
				[
					'invest'=>$invest
				]
		);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		//
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		//
	}

	/**
	* Display the specified resource.
	*
	* @param  \App\InvestList  $investList
	* @return \Illuminate\Http\Response
	*/
	public function show(InvestList $investList)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\InvestList  $investList
	* @return \Illuminate\Http\Response
	*/
	public function edit(InvestList $investList)
	{
		//
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\InvestList  $investList
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, InvestList $investList)
	{
		//
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\InvestList  $investList
	* @return \Illuminate\Http\Response
	*/
	public function destroy(InvestList $investList)
	{
		//
	}
}

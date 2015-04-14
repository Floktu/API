#Floktu API v2.0

##Overview

The Floktu API allows other websites and applications to access a Floktu user's event and attendee data.

This is an advanced tool which is only for programmers - if you do not have access to a programmer in your organisation, please contact [Floktu Support](http://support.floktu.com) for assistance.

###How it Works

You create an application which accesses the Floktu API on behalf of a Floktu user. When the user of your application wants to connect to their Floktu account, you send them to the Floktu OAuth page. They use their Floktu login to authorise your application to access to their Floktu account. The OAuth page then returns a token that allows your application to access that user's event and attendee data through the API.

##Getting Started

###Register for the Floktu API
You need a Floktu Client Id and Client Secret to access the API. If you don't have these yet, you will need to [contact us](http://support.floktu.com/) to request API access.

###Download Sample Client Code

The best way to get started is using our example client code, which you can download from this page.

The sample code shows you how to authenticate with Floktu using OAuth2, and make api calls to retrieve events and attendees.

Currently the sample code is only available in PHP - example code in other languages can be made available on request.  


##Workflow and authentication
###Basic workflow

* You authenticate Floktu users for our API by sending them to our OAuth2 authentication page.
* Once the user has authenticated, we will send an **authentication code** back to you by POST to the redirect uri you specify.
* You make another POST request to exchange the **authentication code** for an **access token**.
* You store the **access token** (we don't expire access tokens, so you will only need to request this once per user - we don't support refresh tokens).
* To access our API, you make a POST or GET request to one of our API endpoints using the **access token**.


###OAuth2 Authentication

Useful reading:

* We recommend this [simple explanation](http://aaronparecki.com/articles/2012/07/29/1/oauth2-simplified) of OAuth2. In particular, see the section on [Web Server Apps](http://aaronparecki.com/articles/2012/07/29/1/oauth2-simplified#web-server-apps)

We've based our OAuth2 implementation on MailChimp's v1.3 api. Basically, we use OAuth2 *without* refresh tokens, and never expire access tokens. For security, all OAuth and API endpoints use SSL.

These are our OAuth2 endpoints:

* **authorize\_uri:** https://floktu.com/api/v2/authorize
* **access\_token\_uri:** https://floktu.com/api/v2/token


##API Endpoints

To access an API endpoint, you make a GET or POST request, passing the access token header as 'Authorization: Bearer'. You will receive a JSON formatted response.

###Events
https://floktu.com/api/v2/events

Provides a list of all events the user has access to.

####JSON Schema	
	{
		"name": "Event",
		"properties": {
			"id": {
				"type": "integer",
				"description": "Unique identifier for the event",
				"required": true
			},
			"name": {
				"type": "string",
				"id": "Name of the event",
				"required": true
			}
		}
	}


<a name="endpoints_orders"></a>

###Orders
https://floktu.com/api/v2/events/{eventid}/orders

Provides a list of all orders for an event. Replace {eventid} in the url with a numeric event id.

This list contains basic details about orders. For the full details of an order, use the *Order Details* endpoint.

####JSON Schema
	{
		"name": "Order",
		"properties": {
			"id": {
				"type": "integer",
				"description": "Unique identifier for the order",
				"required": true
			},
			"email": {
				"type": "string",
				"description": "Email address of the person who placed the order",
				"required": true
			},
			"first_name": {
				"type": "string",
				"description": "First name of the person who placed the order",
				"required": true
			},
			"last_name": {
				"type": "string",
				"description": "Last name of the person who placed the order",
				"required": true
			}
		}
	}

###Order Details
https://floktu.com/api/v2/events/{eventid}/orders/{orderid}

Provides details of an order, including ticket and attendee information. Replace {eventid} in the url with a numeric event id, and {orderid} in the url with a numeric order id.

In Floktu, each event can have many orders, and each order can have many attendees. This endpoint gives the details of a single order, and the details of all attendees associated with that order.

####JSON Schema
	{
		"name": "Order",
		"properties": {
			"id": {
				"type": "integer",
				"description": "Unique identifier for the order",
				"required": true
			},
			"name": {
				"type": "string",
				"description": "Full name of the person who placed the order",
				"required": true
			},
			"email": {
				"type": "string",
				"description": "Email address of the person who placed the order",
				"required": true
			},
			"order_amount": {
				"type": "number",
				"description": "Total amount payable for the order, with the amount in the currency of the event, as a decimal (e.g. a value of 24.17 represents twenty-four dollars and seventeen cents)",
				"required": true
			}
			"amount_paid": {
				"type": "number",
				"description": "Total amount paid for the order, with the amount in the currency of the event, as a decimal (e.g. a value of 24.17 represents twenty-four dollars and seventeen cents)",
				"required": true
			}
			"voucher": {
				"type": "string",
				"description": "Voucher code used for the order (if any)",
				"required": false
			}
			"status": {
				"type": "string",
				"description": "Status of the order - unconfirmed, confirmed or cancelled",
				"required": true
			}
			"attendees": {
				"type": "array",
				"description": "List of attendees associated with the order",
				"required": false
				"items": {
					"type": "object",
					"properties": {
						"attendee_id": {
							"type": "integer",
							"description": "Unique identifier for the attendee",
							"required": true
						},
						"ticket_group": {
							"type": "string",
							"description": "Name of the group the ticket belongs to",
							"required": false
						},
						"ticket": {
							"type": "string",
							"description": "Name of the ticket the attendee has",
							"required": true
						},
						"check_in_date": {
							"type": "string",
							"description": "Date the attendee checked in (if they have checked in)",
							"required": false
						},
						"attendee_first_name": {
							"type": "string",
							"description": "First name of the attendee",
							"required": false
						},
						"attendee_last_name": {
							"type": "string",
							"description": "Last name of the attendee",
							"required": false
						},
						"attendee_company": {
							"type": "string",
							"description": "Name of the attendee's company",
							"required": false
						},
						"attendee_data": {
							"type": "array",
							"description": "Additional attendee data captured during registration",
							"required": false
							"items": {
								"type":"object",
								"properties":{
									"question": {
										"type":"string",
										"description": "The question asked on the form.",
										"required":true
									},
									"answer": {
										"type":"string",
										"description": "The answer the attendee gave to the question.",
										"required":false
									}
								}
							}
						}
					}
				}
			}
		}
	}
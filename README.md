Floktu API

###Contents

##Overview

The Floktu API allows other websites and applications to access a Floktu user's event and attendee data.

This is an advanced tool which can only be used by a programmer - if you do not have access to a programmer, please contact [Floktu Support](http://support.floktu.com) for assistance.

###How it Works

You create an application which accesses the Floktu API on behalf of Floktu users. When your customer wants to connect to their Floktu account, you send them to the Floktu OAuth page. Once they have given you access to their Floktu account, you will be able to access that user's event and attendee data through the API.

##Getting Started

###Register for the Floktu API
You need a Floktu Client Id and Client Secret to access the API. If you don't have these yet, you will need to [contact us](http://support.floktu.com/) to request API access.

###Download Sample Client Code

The best way to get started is using our example client code.

* [Example PHP Client](https://github.com/Floktu/API)

The sample code shows you how to authenticate with Floktu using OAuth2, and make api calls to retrieve events and attendees.

Example code in other languages can be made available on request.  

- - -
##Workflow and authentication
###Basic workflow

* You authenticate Floktu users for our API by sending them to our OAuth2 authentication page.
* Once the user has authenticated, we will send an **authentication code** back to you by POST to the redirect uri you specify.
* You make another POST request to exchange the **authentication code** for an **access token**.
* You store the **access token** (we don't expire access tokens, so you will only need to request this once per user - we don't support refresh tokens).
* To access our API, you make a POST or GET request to one of our API endpoints using the **access token**.


###OAuth2 Authentication

Useful reading:

* If you want it, this is the [OAuth2 v10 spec](http://tools.ietf.org/html/draft-ietf-oauth-v2-31) (very long and boring).
* We recommend this [simple explanation](http://aaronparecki.com/articles/2012/07/29/1/oauth2-simplified) of OAuth2. In particular, see the section on [Web Server Apps](http://aaronparecki.com/articles/2012/07/29/1/oauth2-simplified#web-server-apps)

We've based our OAuth2 implementation on MailChimp's v1.3 api. Basically, we use OAuth2 *without* refresh tokens, and never expire access tokens. For security, all OAuth and API endpoints use SSL.

These are our OAuth2 endpoints:

* **authorize_uri:** https://floktu.com/api/v1/authorize
* **access_token_uri:** https://floktu.com/api/v1/token

- - -
##API Endpoints

To access an API endpoint, you make a GET or POST request must pass the access token header as 'Authorization: Bearer'. You will receive a JSON formatted response.

###Events
https://floktu.com/api/v1/events

Provides a list of all events the user has access to.

####JSON Schema	
	{
		"name": "Event",
		"properties": {
			"id": {
				"type": "string",
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


<a name="endpoints_attendees"></a>
###Attendees
https://floktu.com/api/v1/events/{id}/attendees

Provides a list of all attendees for a given event. Replace {id} in the url with a numeric event id.

In Floktu, each event can have many orders, and each order can have many attendees. This list gives you all attendees,
and for each attendee it specifies the order and event it belongs to. You can group attendees by order to get all attendees for a single order.

####JSON Schema
	{
		"name": "Attendee",
		"properties": {
			"event_id": {
				"type": "string",
				"description": "Unique identifier for the event",
				"required": true
			},
			"event": {
				"type": "string",
				"description": "Name of the event",
				"required": true
			},
			"order_id": {
				"type": "string",
				"description": "Unique identifier for the order",
				"required": true
			},
			"order_email": {
				"type": "string",
				"description": "Email address of the person who placed the order",
				"required": true
			},
			"order_first_name": {
				"type": "string",
				"description": "First name of the person who placed the order",
				"required": true
			},
			"order_last_name": {
				"type": "string",
				"description": "Last name of the person who placed the order",
				"required": true
			},
			"voucher_code": {
				"type": "string",
				"description": "Discount voucher used for the order, if any",
				"required": false
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
			"attendee_id": {
				"type": "string",
				"description": "Unique identifier for the attendee",
				"required": true
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
			},
		}
	}
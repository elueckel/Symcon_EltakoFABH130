<?php
	class EltakoFABH130 extends IPSModule
	{
		public function Create() 
		{
			//Never delete this line!
			parent::Create();
			$this->RegisterPropertyInteger("SourceID", 0);
			$this->RegisterPropertyInteger("DeviceID", 0);
			$this->RegisterPropertyString("ReturnID", "");

			$this->RegisterPropertyString("BaseData", '{
				"DataID":"{70E3075F-A35D-4DEB-AC20-C929A156FE48}",
				"Device":246,
				"Status":0,
				"DeviceID":0,
				"DestinationID":-1,
				"DataLength":4,
				"DataByte12":0,
				"DataByte11":0,
				"DataByte10":0,
				"DataByte9":0,
				"DataByte8":0,
				"DataByte7":0,
				"DataByte6":0,
				"DataByte5":0,
				"DataByte4":0,
				"DataByte3":0,
				"DataByte2":0,
				"DataByte1":0,
				"DataByte0":0
			}');
			
			$this->RegisterVariableBoolean('Motion', $this->Translate('Motion'), "~Motion");

			
			//Connect to available enocean gateway
			$this->ConnectParent("{A52FEFE9-7858-4B8E-A96E-26E15CB944F7}");
			
#			
		}

		public function Destroy(){
		    //Never delete this line!
		    parent::Destroy();

		}
    
		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
			
#			Filter setzen
			$this->SetReceiveDataFilter(".*\"DeviceID\":".(int)hexdec($this->ReadPropertyString("ReturnID")).",.*");

		}
		
		public function ReceiveData($JSONString)
		{
			$this->SendDebug("Receive from Device", $JSONString, 0);
			$data = json_decode($JSONString);
		
			$motion = $data->Status;
			$this->SendDebug("Trigger Value", $motion, 0);
			
			If ($motion == 32)			
				{
				$this->SendDebug("Variable set to", 0, 0);	
				$sourceID = $this->ReadPropertyInteger("SourceID");	
				SetValue($this->GetIDForIdent("Motion"), 0);	
				}
			
			If ($motion == 48)			
				{
				$this->SendDebug("Variable set to", 1, 0);	
				$sourceID = $this->ReadPropertyInteger("SourceID");	
				SetValue($this->GetIDForIdent("Motion"), 1);	
				}
				
		}
			
	}

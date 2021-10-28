<?php

namespace App\DTO;

class OfficeDTO
{
   private $code;
   private $description;
   private $unitCode;
   private $unitDescription;
   private $provinceCode;
   private $provinceDescription;
   private $rootUnitCode;
   private $rootUnitDescription;



   /**
    * Get the value of code
    */
   public function getCode()
   {
      return $this->code;
   }

   /**
    * Set the value of code
    *
    * @return  self
    */
   public function setCode($code)
   {
      $this->code = $code;

      return $this;
   }

   /**
    * Get the value of description
    */
   public function getDescription()
   {
      return $this->description;
   }

   /**
    * Set the value of description
    *
    * @return  self
    */
   public function setDescription($description)
   {
      $this->description = $description;

      return $this;
   }

   /**
    * Get the value of unitCode
    */
   public function getUnitCode()
   {
      return $this->unitCode;
   }

   /**
    * Set the value of unitCode
    *
    * @return  self
    */
   public function setUnitCode($unitCode)
   {
      $this->unitCode = $unitCode;

      return $this;
   }

   /**
    * Get the value of unitDescription
    */
   public function getUnitDescription()
   {
      return $this->unitDescription;
   }

   /**
    * Set the value of unitDescription
    *
    * @return  self
    */
   public function setUnitDescription($unitDescription)
   {
      $this->unitDescription = $unitDescription;

      return $this;
   }

   /**
    * Get the value of provinceCode
    */
   public function getProvinceCode()
   {
      return $this->provinceCode;
   }

   /**
    * Set the value of provinceCode
    *
    * @return  self
    */
   public function setProvinceCode($provinceCode)
   {
      $this->provinceCode = $provinceCode;

      return $this;
   }

   /**
    * Get the value of provinceDescription
    */
   public function getProvinceDescription()
   {
      return $this->provinceDescription;
   }

   /**
    * Set the value of provinceDescription
    *
    * @return  self
    */
   public function setProvinceDescription($provinceDescription)
   {
      $this->provinceDescription = $provinceDescription;

      return $this;
   }

   /**
    * Get the value of rootUnitCode
    */
   public function getRootUnitCode()
   {
      return $this->rootUnitCode;
   }

   /**
    * Set the value of rootUnitCode
    *
    * @return  self
    */
   public function setRootUnitCode($rootUnitCode)
   {
      $this->rootUnitCode = $rootUnitCode;

      return $this;
   }

   /**
    * Get the value of rootUnitDescription
    */
   public function getRootUnitDescription()
   {
      return $this->rootUnitDescription;
   }

   /**
    * Set the value of rootUnitDescription
    *
    * @return  self
    */
   public function setRootUnitDescription($rootUnitDescription)
   {
      $this->rootUnitDescription = $rootUnitDescription;

      return $this;
   }

   public function fill(array $officeArray): self
   {
      $this->code = $officeArray['codigo'];
      $this->description = $officeArray['denominacion'];
      $this->unitCode = $officeArray['codigoUnidad'];
      $this->unitDescription = $officeArray['denominacionUnidad'];
      $this->provinceCode = $officeArray['codigoProvincia'];
      $this->provinceDescription = $officeArray['denominacionProvincia'];
      $this->rootUnitCode = $officeArray['codigoUnidadRaiz'];
      $this->rootUnitDescription = $officeArray['denominacionUnidadRaiz'];

      return $this;
   }
}

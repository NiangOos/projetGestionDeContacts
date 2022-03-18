import { Component, OnInit } from '@angular/core';
import { contactservice } from '../contact.service'
import { Contact } from '../contact'

@Component({
  selector: 'app-index',
  templateUrl: './index.component.html',
  styleUrls: ['./index.component.scss']
})
export class IndexComponent implements OnInit {

  contacts: Contact[] = [];

  constructor(public contactservice: contactservice) { }

  ngOnInit(): void {
    this.contactservice.getAll().subscribe((data: Contact[]): void => {
      this.contacts = data;
      console.log(this.contacts);
    })
  }

  deleteContact(id: number) {
    this.contactservice.delete(id).subscribe(res => {
      this.contacts = this.contacts.filter(item => item.id !== id);
      console.log('Contact deleted successfully!');
    })
  }

}